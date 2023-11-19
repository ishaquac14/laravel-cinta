<nav aria-label="Page navigation example">
    <ul class="pagination pagination-dark">
        <li class="page-item {{ $physicals->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $physicals->previousPageUrl() }}" tabindex="-1" aria-disabled="{{ $physicals->onFirstPage() ? 'true' : 'false' }}">Previous</a>
        </li>
        @foreach(range(1, $physicals->lastPage()) as $page)
            <li class="page-item {{ $physicals->currentPage() === $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $physicals->url($page) }}">{{ $page }}</a>
            </li>
        @endforeach
        <li class="page-item {{ $physicals->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $physicals->nextPageUrl() }}" aria-disabled="{{ $physicals->hasMorePages() ? 'false' : 'true' }}">Next</a>
        </li>
    </ul>
</nav>
