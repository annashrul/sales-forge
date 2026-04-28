<?php

namespace App\Http\Controllers;

use App\Models\SalesPage;
use App\Services\SalesPageGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class SalesPageController extends Controller
{
    public function __construct(protected SalesPageGenerator $generator) {}

    public function index(Request $request)
    {
        $query = SalesPage::query()
            ->where('user_id', $request->user()->id)
            ->latest();

        if ($search = trim((string) $request->query('q', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('target_audience', 'like', "%{$search}%");
            });
        }

        $pages = $query->paginate(12)->withQueryString();

        return view('sales_pages.index', [
            'pages' => $pages,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('sales_pages.create', [
            'page' => new SalesPage(['tone' => 'persuasive', 'template' => 'modern']),
            'submitLabel' => 'Generate Sales Page',
            'formAction' => route('sales-pages.store'),
            'formMethod' => 'POST',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateInput($request);

        $page = SalesPage::create([
            'user_id' => $request->user()->id,
            ...$data,
            'status' => 'generating',
        ]);

        $this->runGeneration($page);

        return redirect()
            ->route('sales-pages.show', $page)
            ->with('status', $page->status === 'ready'
                ? 'Sales page generated successfully.'
                : 'Generated with a fallback — see error notice on the page.');
    }

    public function show(Request $request, SalesPage $salesPage)
    {
        $this->authorizeOwner($request, $salesPage);

        return view('sales_pages.show', ['page' => $salesPage]);
    }

    public function edit(Request $request, SalesPage $salesPage)
    {
        $this->authorizeOwner($request, $salesPage);

        return view('sales_pages.create', [
            'page' => $salesPage,
            'submitLabel' => 'Generate Sales Page',
            'formAction' => route('sales-pages.update', $salesPage),
            'formMethod' => 'PUT',
        ]);
    }

    public function update(Request $request, SalesPage $salesPage): RedirectResponse
    {
        $this->authorizeOwner($request, $salesPage);

        $data = $this->validateInput($request);

        $salesPage->fill($data);
        $salesPage->status = 'generating';
        $salesPage->save();

        $this->runGeneration($salesPage);

        return redirect()
            ->route('sales-pages.show', $salesPage)
            ->with('status', 'Sales page regenerated.');
    }

    public function destroy(Request $request, SalesPage $salesPage): RedirectResponse
    {
        $this->authorizeOwner($request, $salesPage);

        $salesPage->delete();

        return redirect()
            ->route('sales-pages.index')
            ->with('status', 'Sales page deleted.');
    }

    public function exportHtml(Request $request, SalesPage $salesPage): Response
    {
        $this->authorizeOwner($request, $salesPage);
        abort_unless($salesPage->isReady(), 404, 'Sales page is not ready yet.');

        $html = view('sales_pages.exports.standalone', ['page' => $salesPage])->render();
        $filename = \Illuminate\Support\Str::slug($salesPage->product_name ?: 'sales-page') . '.html';

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    protected function validateInput(Request $request): array
    {
        $validated = $request->validate([
            'product_name' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'min:20', 'max:2000'],
            'features' => ['required', 'string', 'max:2000'],
            'target_audience' => ['required', 'string', 'max:160'],
            'price' => ['nullable', 'string', 'max:80'],
            'unique_selling_points' => ['nullable', 'string', 'max:1000'],
            'tone' => ['required', Rule::in(['formal', 'casual', 'persuasive', 'urgent', 'inspirational'])],
            'template' => ['required', Rule::in(['modern', 'classic', 'bold'])],
        ]);

        $validated['features'] = array_values(array_filter(array_map(
            'trim',
            preg_split('/[\r\n,]+/', (string) $validated['features'])
        )));

        return $validated;
    }

    protected function runGeneration(SalesPage $page): void
    {
        try {
            $output = $this->generator->generate([
                'product_name' => $page->product_name,
                'description' => $page->description,
                'features' => $page->features ?? [],
                'target_audience' => $page->target_audience,
                'price' => $page->price,
                'unique_selling_points' => $page->unique_selling_points,
                'tone' => $page->tone,
                'template' => $page->template,
            ]);

            $error = $output['_error'] ?? null;
            unset($output['_error']);

            $page->generated_content = $output;
            $page->status = 'ready';
            $page->error = $error;
            $page->save();
        } catch (\Throwable $e) {
            $page->status = 'failed';
            $page->error = $e->getMessage();
            $page->save();
        }
    }

    protected function authorizeOwner(Request $request, SalesPage $page): void
    {
        abort_unless($page->user_id === $request->user()->id, 403);
    }
}
