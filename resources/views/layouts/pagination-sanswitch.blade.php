<nav aria-label="Page navigation example">
    <ul class="pagination pagination-dark">
        <li class="page-item {{ $sanswitchs->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $sanswitchs->previousPageUrl() }}" tabindex="-1" aria-disabled="{{ $sanswitchs->onFirstPage() ? 'true' : 'false' }}">Previous</a>
        </li>
        @foreach(range(1, $sanswitchs->lastPage()) as $page)
            <li class="page-item {{ $sanswitchs->currentPage() === $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $sanswitchs->url($page) }}">{{ $page }}</a>
            </li>
        @endforeach
        <li class="page-item {{ $sanswitchs->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $sanswitchs->nextPageUrl() }}" aria-disabled="{{ $sanswitchs->hasMorePages() ? 'false' : 'true' }}">Next</a>
        </li>
    </ul>
</nav>
