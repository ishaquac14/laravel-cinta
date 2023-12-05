<nav aria-label="Page navigation example">
    <ul class="pagination pagination-dark">
        <li class="page-item {{ $csdatabases->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $csdatabases->previousPageUrl() }}" tabindex="-1" aria-disabled="{{ $csdatabases->onFirstPage() ? 'true' : 'false' }}">Previous</a>
        </li>
        @foreach(range(1, $csdatabases->lastPage()) as $page)
            <li class="page-item {{ $csdatabases->currentPage() === $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $csdatabases->url($page) }}">{{ $page }}</a>
            </li>
        @endforeach
        <li class="page-item {{ $csdatabases->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $csdatabases->nextPageUrl() }}" aria-disabled="{{ $csdatabases->hasMorePages() ? 'false' : 'true' }}">Next</a>
        </li>
    </ul>
</nav>
