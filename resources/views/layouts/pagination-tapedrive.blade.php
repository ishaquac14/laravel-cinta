<nav aria-label="Page navigation example">
    <ul class="pagination pagination-dark">
        <li class="page-item {{ $tapedrives->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $tapedrives->previousPageUrl() }}" tabindex="-1" aria-disabled="{{ $tapedrives->onFirstPage() ? 'true' : 'false' }}">Previous</a>
        </li>
        @foreach(range(1, $tapedrives->lastPage()) as $page)
            <li class="page-item {{ $tapedrives->currentPage() === $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $tapedrives->url($page) }}">{{ $page }}</a>
            </li>
        @endforeach
        <li class="page-item {{ $tapedrives->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $tapedrives->nextPageUrl() }}" aria-disabled="{{ $tapedrives->hasMorePages() ? 'false' : 'true' }}">Next</a>
        </li>
    </ul>
</nav>
