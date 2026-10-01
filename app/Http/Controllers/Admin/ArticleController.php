<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')
            ->paginate(20);
        $categories = Category::all();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.articles.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_fr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'content_fr' => 'required|string',
            'content_en' => 'required|string',
            'content_ar' => 'required|string',
            'summary_fr' => 'nullable|string',
            'summary_en' => 'nullable|string',
            'summary_ar' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,archived',
            'publish' => 'nullable|boolean',
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        $validated['created_by'] = auth()->id();

        if (isset($validated['publish']) && $validated['publish']) {
            $validated['status'] = 'published';
            $validated['published_at'] = now();
        }
        unset($validated['publish']);

        Article::create($validated);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article créé avec succès');
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('admin.articles.form', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title_fr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'content_fr' => 'required|string',
            'content_en' => 'required|string',
            'content_ar' => 'required|string',
            'summary_fr' => 'nullable|string',
            'summary_en' => 'nullable|string',
            'summary_ar' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,archived',
            'publish' => 'nullable|boolean',
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        $validated['updated_by'] = auth()->id();

        if (isset($validated['publish']) && $validated['publish'] && $article->status !== 'published') {
            $validated['status'] = 'published';
            $validated['published_at'] = now();
        }
        unset($validated['publish']);

        $article->update($validated);

        return redirect()->route('admin.articles.edit', $article)
            ->with('success', 'Article mis à jour avec succès');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Article supprimé avec succès');
    }

    public function publish(Article $article)
    {
        $article->update(['status' => 'published', 'published_at' => now()]);

        return redirect()->back()->with('success', 'Article publié avec succès');
    }

    public function archive(Article $article)
    {
        $article->update(['status' => 'archived']);

        return redirect()->back()->with('success', 'Article archivé avec succès');
    }
}