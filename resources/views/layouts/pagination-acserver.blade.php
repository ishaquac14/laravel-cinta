<nav aria-label="Page navigation example">
    <ul class="pagination pagination-dark">
        <li class="page-item {{ $acservers->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $acservers->previousPageUrl() }}" tabindex="-1" aria-disabled="{{ $acservers->onFirstPage() ? 'true' : 'false' }}">Previous</a>
        </li>
        @foreach(range(1, $acservers->lastPage()) as $page)
            <li class="page-item {{ $acservers->currentPage() === $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $acservers->url($page) }}">{{ $page }}</a>
            </li>
        @endforeach
        <li class="page-item {{ $acservers->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $acservers->nextPageUrl() }}" aria-disabled="{{ $acservers->hasMorePages() ? 'false' : 'true' }}">Next</a>
        </li>
    </ul>
</nav>
