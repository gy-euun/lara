@extends('layouts.app')

@section('scripts')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect typography inlinecss',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            language: 'ko_KR',
            height: 500,
            menubar: true,
            images_upload_handler: function (blobInfo, progress) {
                return new Promise((resolve, reject) => {
                    const formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    
                    fetch('/upload-image', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(result => {
                        resolve(result.location);
                    })
                    .catch(error => {
                        reject('이미지 업로드 실패: ' + error);
                    });
                });
            },
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            }
        });
    </script>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <h1 class="text-2xl font-bold">✏️ 새 게시글 작성</h1>
        </div>

        <form action="{{ route('community.posts.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
            @csrf
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">제목</label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       value="{{ old('title') }}"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category" class="block text-sm font-medium text-gray-700">카테고리</label>
                <select name="category" 
                        id="category" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="general">일반</option>
                    <option value="notice">공지사항</option>
                    <option value="question">질문</option>
                    <option value="discussion">토론</option>
                </select>
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-700">내용</label>
                <textarea name="content" 
                          id="content" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                          required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="attachments" class="block text-sm font-medium text-gray-700">첨부파일</label>
                <input type="file" 
                       name="attachments[]" 
                       id="attachments" 
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                       multiple>
                <p class="mt-1 text-sm text-gray-500">여러 파일을 선택할 수 있습니다 (최대 5개)</p>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('community.posts.index') }}" 
                   class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                    취소
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    작성하기
                </button>
            </div>
        </form>
    </div>
@endsection 