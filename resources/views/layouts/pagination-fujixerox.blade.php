<nav aria-label="Page navigation example">
    <ul class="pagination pagination-dark">
        <li class="page-item {{ $fujixeroxs->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $fujixeroxs->previousPageUrl() }}" tabindex="-1" aria-disabled="{{ $fujixeroxs->onFirstPage() ? 'true' : 'false' }}">Previous</a>
        </li>
        @foreach(range(1, $fujixeroxs->lastPage()) as $page)
            <li class="page-item {{ $fujixeroxs->currentPage() === $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $fujixeroxs->url($page) }}">{{ $page }}</a>
            </li>
        @endforeach
        <li class="page-item {{ $fujixeroxs->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $fujixeroxs->nextPageUrl() }}" aria-disabled="{{ $fujixeroxs->hasMorePages() ? 'false' : 'true' }}">Next</a>
        </li>
    </ul>
</nav>
