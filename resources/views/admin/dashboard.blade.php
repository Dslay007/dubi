@extends('layouts.admin')

@section('pageTitle', 'Dashboard Overview')

@section('content')
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
    <!-- Stat Card 1 -->
    <div style="background: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid #e2e8f0; display: flex; align-items: start; gap: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <div style="background: #eff6ff; padding: 1rem; border-radius: 0.75rem; color: #3b82f6;">
            <i data-lucide="book" style="width: 2rem; height: 2rem;"></i>
        </div>
        <div>
            <h3 style="color: #64748b; font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Total Collections</h3>
            <p style="font-size: 2.25rem; font-weight: 800; color: #1e293b; margin-top: 0.25rem; line-height: 1;">
                {{ \App\Models\Biblio::count() }}
            </p>
            <span style="font-size: 0.875rem; color: #10b981; font-weight: 500; display: flex; align-items: center; gap: 0.25rem; margin-top: 0.5rem;">
                <i data-lucide="trending-up" style="width: 1rem;"></i> Growing
            </span>
        </div>
    </div>
    
    <!-- Stat Card 2 -->
    <div style="background: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid #e2e8f0; display: flex; align-items: start; gap: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
         <div style="background: #f0fdf4; padding: 1rem; border-radius: 0.75rem; color: #22c55e;">
            <i data-lucide="users" style="width: 2rem; height: 2rem;"></i>
        </div>
        <div>
            <h3 style="color: #64748b; font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Total Members</h3>
            <p style="font-size: 2.25rem; font-weight: 800; color: #1e293b; margin-top: 0.25rem; line-height: 1;">
                {{ \App\Models\Member::count() }}
            </p>
            <span style="font-size: 0.875rem; color: #64748b; font-weight: 500; margin-top: 0.5rem; display: block;">
                Registered Users
            </span>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div style="background: white; padding: 1.5rem; border-radius: 1rem; border: 1px solid #e2e8f0; display: flex; align-items: start; gap: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
         <div style="background: #fff1f2; padding: 1rem; border-radius: 0.75rem; color: #f43f5e;">
            <i data-lucide="arrow-right-left" style="width: 2rem; height: 2rem;"></i>
        </div>
        <div>
            <h3 style="color: #64748b; font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Active Loans</h3>
            <p style="font-size: 2.25rem; font-weight: 800; color: #1e293b; margin-top: 0.25rem; line-height: 1;">
                {{ \App\Models\Loan::where('is_return', 0)->count() }}
            </p>
            <span style="font-size: 0.875rem; color: #f59e0b; font-weight: 500; display: flex; align-items: center; gap: 0.25rem; margin-top: 0.5rem;">
                <i data-lucide="clock" style="width: 1rem;"></i> Outstanding
            </span>
        </div>
    </div>
</div>

<div style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); padding: 3rem; border-radius: 1rem; color: white; position: relative; overflow: hidden;">
    <div style="position: relative; z-index: 1;">
        <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Welcome back, {{ $user->realname }}!</h2>
        <p style="color: #94a3b8; font-size: 1.1rem; max-width: 600px;">
            The system is running smoothly. Use the sidebar menu to manage collections, members, and transactions.
        </p>
        <div style="margin-top: 2rem; display: flex; gap: 1rem;">
            <a href="{{ route('admin.circulation.index') }}" class="btn" style="background: #3b82f6; color: white; padding: 0.75rem 2rem; border-radius: 99px; text-decoration: none;">Start Transaction</a>
            <a href="{{ route('admin.biblio.create') }}" class="btn" style="background: rgba(255,255,255,0.1); color: white; padding: 0.75rem 2rem; border-radius: 99px; text-decoration: none; backdrop-filter: blur(10px);">Add New Book</a>
        </div>
    </div>
    
    <!-- Background Decor -->
    <i data-lucide="library" style="position: absolute; right: -2rem; bottom: -2rem; width: 20rem; height: 20rem; opacity: 0.05; transform: rotate(-15deg);"></i>
</div>
@endsection

