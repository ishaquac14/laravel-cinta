<nav aria-label="Page navigation example">
    <ul class="pagination pagination-dark">
        <li class="page-item {{ $gacsirts->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $gacsirts->previousPageUrl() }}" tabindex="-1" aria-disabled="{{ $gacsirts->onFirstPage() ? 'true' : 'false' }}">Previous</a>
        </li>
        @foreach(range(1, $gacsirts->lastPage()) as $page)
            <li class="page-item {{ $gacsirts->currentPage() === $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $gacsirts->url($page) }}">{{ $page }}</a>
            </li>
        @endforeach
        <li class="page-item {{ $gacsirts->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $gacsirts->nextPageUrl() }}" aria-disabled="{{ $gacsirts->hasMorePages() ? 'false' : 'true' }}">Next</a>
        </li>
    </ul>
</nav>
