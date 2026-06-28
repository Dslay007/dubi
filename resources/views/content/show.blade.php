@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 3rem; max-width: 800px;">
    <h1 style="font-size: 2.5rem; font-weight: 800; color: #1e293b; margin-bottom: 2rem;">{{ $content->content_title }}</h1>
    
    <div style="font-size: 1.1rem; color: #334155; line-height: 1.8;">
        {!! clean($content->content_desc) !!}
    </div>

    <div style="margin-top: 3rem; padding-top: 1rem; border-top: 1px solid #e2e8f0; color: #64748b; font-size: 0.9rem;">
        Last updated: {{ \Carbon\Carbon::parse($content->last_update)->format('d M Y') }}
    </div>
</div>
@endsection
