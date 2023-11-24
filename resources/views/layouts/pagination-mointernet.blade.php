<nav aria-label="Page navigation example">
    <ul class="pagination pagination-dark">
        <li class="page-item {{ $mointernets->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $mointernets->previousPageUrl() }}" tabindex="-1" aria-disabled="{{ $mointernets->onFirstPage() ? 'true' : 'false' }}">Previous</a>
        </li>
        @foreach(range(1, $mointernets->lastPage()) as $page)
            <li class="page-item {{ $mointernets->currentPage() === $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $mointernets->url($page) }}">{{ $page }}</a>
            </li>
        @endforeach
        <li class="page-item {{ $mointernets->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $mointernets->nextPageUrl() }}" aria-disabled="{{ $mointernets->hasMorePages() ? 'false' : 'true' }}">Next</a>
        </li>
    </ul>
</nav>
