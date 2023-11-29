<nav aria-label="Page navigation example">
    <ul class="pagination pagination-dark">
        <li class="page-item {{ $cctvs->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $cctvs->previousPageUrl() }}" tabindex="-1" aria-disabled="{{ $cctvs->onFirstPage() ? 'true' : 'false' }}">Previous</a>
        </li>
        @foreach(range(1, $cctvs->lastPage()) as $page)
            <li class="page-item {{ $cctvs->currentPage() === $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $cctvs->url($page) }}">{{ $page }}</a>
            </li>
        @endforeach
        <li class="page-item {{ $cctvs->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $cctvs->nextPageUrl() }}" aria-disabled="{{ $cctvs->hasMorePages() ? 'false' : 'true' }}">Next</a>
        </li>
    </ul>
</nav>
