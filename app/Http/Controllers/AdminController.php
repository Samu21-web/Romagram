<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Swipe;
use App\Models\Favourite;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Page;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers      = User::where('is_admin', false)->count();
        $premiumUsers    = User::where('subscription_plan', 'premium')->orWhere('subscription_plan', 'gold')->count();
        $newToday        = User::whereDate('created_at', today())->where('is_admin', false)->count();
        $totalSwipes     = Swipe::count();
        $totalFavourites = Favourite::count();

        $usersByCity = User::where('is_admin', false)
            ->whereNotNull('city')
            ->selectRaw('city, count(*) as total')
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $recentUsers = User::where('is_admin', false)
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'premiumUsers', 'newToday',
            'totalSwipes', 'totalFavourites', 'usersByCity', 'recentUsers'
        ));
    }

public function users(Request $request)
{
    $query = User::where('is_admin', false)->latest();

    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', '%'.$request->search.'%')
              ->orWhere('email', 'like', '%'.$request->search.'%')
              ->orWhere('phone', 'like', '%'.$request->search.'%');
        });
    }

    if ($request->type === 'premium') {
        $query->whereIn('subscription_plan', ['premium', 'gold']);
    } elseif ($request->type === 'regular') {
        $query->whereNotIn('subscription_plan', ['premium', 'gold'])
              ->orWhereNull('subscription_plan');
    } elseif ($request->type === 'deactivated') {
        $query->where('is_deactivated', true);
    } elseif ($request->type === 'featured') {
        $query->where('is_featured', true);
    }

    $users            = $query->paginate(15);
    $totalUsers       = User::where('is_admin', false)->count();
    $premiumCount     = User::whereIn('subscription_plan', ['premium', 'gold'])->count();
    $deactivatedCount = User::where('is_admin', false)->where('is_deactivated', true)->count();
    $featuredCount    = User::where('is_admin', false)->where('is_featured', true)->count();
    $regularCount     = $totalUsers - $premiumCount - $deactivatedCount;

    return view('admin.users', compact('users', 'totalUsers', 'premiumCount', 'regularCount', 'deactivatedCount', 'featuredCount'));
}

public function reactivateUser($id)
{
    $user = User::findOrFail($id);
    $user->update([
        'deactivated_at' => null,
        'is_deactivated' => false,
    ]);
    return back()->with('success', 'User reactivated successfully.');
}

public function deactivateUser($id)
{
    $user = User::findOrFail($id);
    $user->update([
        'deactivated_at' => now(),
        'is_deactivated' => true,
    ]);
    return back()->with('success', 'User deactivated successfully.');
}

public function toggleFeatured($id)
{
    $user = User::findOrFail($id);
    $user->update(['is_featured' => !$user->is_featured]);
    return back()->with('success', $user->is_featured ? 'User marked as featured.' : 'User removed from featured.');
}

    public function viewUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user-view', compact('user'));
    }

    public function toggleAdmin($id)
    {
        $user = User::findOrFail($id);
        $user->update(['subscription_plan' => $user->subscription_plan === 'premium' ? null : 'premium']);
        return back()->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function packages()
    {
        $packages = Package::latest()->get();
        return view('admin.packages', compact('packages'));
    }

    public function createPackage(Request $request)
    {
        $request->validate([
            'name'          => 'required|string',
            'price'         => 'required|numeric|min:1',
            'duration_days' => 'required|integer|min:1',
            'description'   => 'nullable|string',
        ]);

        Package::create([
            'name'          => $request->name,
            'slug'          => strtolower(str_replace(' ', '_', $request->name)),
            'price'         => $request->price,
            'duration_days' => $request->duration_days,
            'description'   => $request->description,
            'is_active'     => true,
        ]);

        return back()->with('success', 'Package created successfully.');
    }

    public function togglePackage($id)
    {
        $package = Package::findOrFail($id);
        $package->update(['is_active' => !$package->is_active]);
        return back()->with('success', 'Package updated.');
    }

    public function payments()
    {
        $payments     = Payment::with(['user', 'package'])->latest()->paginate(15);
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $completed    = Payment::where('status', 'completed')->count();
        $pending      = Payment::where('status', 'pending')->count();
        $failed       = Payment::where('status', 'failed')->count();

        return view('admin.payments', compact('payments', 'totalRevenue', 'completed', 'pending', 'failed'));
    }

    public function pages()
    {
        $pages = Page::all();
        return view('admin.pages', compact('pages'));
    }

    public function editPage($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('admin.page-edit', compact('page'));
    }

    public function updatePage(Request $request, $slug)
    {
        $request->validate([
            'title'   => 'required|string',
            'content' => 'required|string',
        ]);

        $page = Page::where('slug', $slug)->firstOrFail();
        $page->update([
            'title'           => $request->title,
            'content'         => $request->content,
            'last_updated_at' => now(),
        ]);

        return back()->with('success', 'Page updated successfully!');
    }
    public function editPackage($id)
{
    $package = Package::findOrFail($id);
    return response()->json($package);
}

public function updatePackage(Request $request, $id)
{
    $request->validate([
        'name'          => 'required|string',
        'price'         => 'required|numeric|min:1',
        'duration_days' => 'required|integer|min:1',
        'description'   => 'nullable|string',
    ]);

    $package = Package::findOrFail($id);
    $package->update([
        'name'          => $request->name,
        'price'         => $request->price,
        'duration_days' => $request->duration_days,
        'description'   => $request->description,
    ]);

    return back()->with('success', 'Package updated successfully!');
}
}