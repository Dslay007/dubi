@extends('layouts.admin')

@section('pageTitle', 'Add New Book')

@section('content')
<div style="background: white; padding: 2rem; border-radius: 0.5rem; border: 1px solid #e2e8f0; max-width: 800px;">
    <h3 style="font-weight: 700; color: #1e293b; margin-bottom: 2rem;">Bibliographic Data</h3>

    <form action="{{ route('admin.biblio.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Title *</label>
            <input type="text" name="title" required class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Statement of Responsibility</label>
                <input type="text" name="sor" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            </div>
            <div>
                 <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Series Title</label>
                <input type="text" name="series_title" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Edition</label>
                <input type="text" name="edition" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            </div>
            <div>
                 <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Specific Detail Info</label>
                <input type="text" name="spec_detail_info" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Call Number</label>
                <input type="text" name="call_number" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            </div>
             <div>
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Classification</label>
                <input type="text" name="classification" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">ISBN/ISSN</label>
                <input type="text" name="isbn_issn" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            </div>
            <div>
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Publisher</label>
                <select name="publisher_id" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
                    <option value="">-- Select Publisher --</option>
                    @foreach(\App\Models\Publisher::all() as $pub)
                        <option value="{{ $pub->publisher_id }}">{{ $pub->publisher_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Publish Year</label>
                <input type="number" name="publish_year" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            </div>
             <div>
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Publish Place</label>
                <select name="publish_place_id" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
                    <option value="">-- Select Place --</option>
                    @foreach(\App\Models\Place::all() as $place)
                        <option value="{{ $place->place_id }}">{{ $place->place_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">GMD</label>
                <select name="gmd_id" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
                     @foreach(\App\Models\Gmd::all() as $gmd)
                        <option value="{{ $gmd->gmd_id }}">{{ $gmd->gmd_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                 <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Language</label>
                 <select name="language" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
                    <option value="en">English</option>
                    <option value="id">Indonesian</option>
                    <option value="ar">Arabic</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div style="grid-column: span 2;">
                 <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Collation (Deskripsi Fisik)</label>
                 <input type="text" name="collation" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
             <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Notes (Catatan)</label>
             <textarea name="notes" rows="3" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;"></textarea>
        </div>

        <div style="margin-bottom: 1.5rem; background: #f8fafc; padding: 1.5rem; border-radius: 0.375rem; border: 1px dashed #cbd5e1;">
            <h4 style="font-weight: 600; color: #1e293b; margin-bottom: 1rem;">Cover Image (Pilih Salah Satu)</h4>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div>
                    <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Upload File</label>
                    <input type="file" name="image" class="input" style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: white;">
                </div>
                <div>
                    <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Atau Paste URL (Download Cover)</label>
                    <input type="url" name="image_url" placeholder="https://" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
                </div>
            </div>
        </div>

        <div style="margin-bottom: 1.5rem; background: #f8fafc; padding: 1.5rem; border-radius: 0.375rem; border: 1px dashed #cbd5e1;">
            <h4 style="font-weight: 600; color: #1e293b; margin-bottom: 1rem;">E-Digital / File Attachment (Opsional)</h4>
            <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 1rem;">Unggah file e-book (PDF/EPUB) atau masukkan link URL untuk buku digital.</p>
            
            <div style="margin-bottom: 1rem;">
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Unggah File (Max 50MB)</label>
                <input type="file" name="file_att_upload" accept=".pdf,.epub" class="input" style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none; background: white;">
            </div>
            
            <div>
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Atau Link URL (G-Drive, dll)</label>
                <input type="url" name="file_att_link" placeholder="https://" class="input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; outline: none;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
            <div>
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Authors</label>
                <div style="padding: 1rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; max-height: 150px; overflow-y: auto; background: white;">
                     @foreach(\App\Models\Author::limit(50)->get() as $author)
                        <div style="margin-bottom: 0.25rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="checkbox" name="author_id[]" value="{{ $author->author_id }}">
                                {{ $author->author_name }}
                            </label>
                        </div>
                    @endforeach
                    @if(\App\Models\Author::count() > 50)
                        <div style="font-size: 0.8rem; color: #64748b; margin-top: 0.5rem; font-style: italic;">Showing top 50 authors...</div>
                    @endif
                </div>
            </div>
            
            <div>
                <label class="label" style="display: block; font-weight: 600; font-size: 0.875rem; color: #475569; margin-bottom: 0.5rem;">Topics / Subjects</label>
                <div style="padding: 1rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; max-height: 150px; overflow-y: auto; background: white;">
                     @foreach(\App\Models\Topic::limit(50)->get() as $topic)
                        <div style="margin-bottom: 0.25rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="checkbox" name="topic_id[]" value="{{ $topic->topic_id }}">
                                {{ $topic->topic }}
                            </label>
                        </div>
                    @endforeach
                    @if(\App\Models\Topic::count() > 50)
                        <div style="font-size: 0.8rem; color: #64748b; margin-top: 0.5rem; font-style: italic;">Showing top 50 topics...</div>
                    @endif
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn" style="padding: 0.75rem 2rem; background: #3b82f6; color: white; border: none; border-radius: 0.375rem; font-weight: 600; cursor: pointer;">Save New Book</button>
            <a href="{{ route('admin.biblio.index') }}" style="padding: 0.75rem 2rem; background: #e2e8f0; color: #475569; text-decoration: none; border-radius: 0.375rem; font-weight: 600;">Cancel</a>
        </div>
    </form>
</div>
@endsection
