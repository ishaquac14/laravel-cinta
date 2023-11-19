<nav aria-label="Page navigation example">
    <ul class="pagination pagination-dark">
        <li class="page-item {{ $databases->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $databases->previousPageUrl() }}" tabindex="-1" aria-disabled="{{ $databases->onFirstPage() ? 'true' : 'false' }}">Previous</a>
        </li>
        @foreach(range(1, $databases->lastPage()) as $page)
            <li class="page-item {{ $databases->currentPage() === $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $databases->url($page) }}">{{ $page }}</a>
            </li>
        @endforeach
        <li class="page-item {{ $databases->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $databases->nextPageUrl() }}" aria-disabled="{{ $databases->hasMorePages() ? 'false' : 'true' }}">Next</a>
        </li>
    </ul>
</nav>
