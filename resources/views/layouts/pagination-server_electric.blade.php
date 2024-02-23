<nav aria-label="Page navigation example">
    <ul class="pagination pagination-dark">
        <li class="page-item {{ $c_server_electrics->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $c_server_electrics->previousPageUrl() }}" tabindex="-1" aria-disabled="{{ $c_server_electrics->onFirstPage() ? 'true' : 'false' }}">Previous</a>
        </li>
        @foreach(range(1, $c_server_electrics->lastPage()) as $page)
            <li class="page-item {{ $c_server_electrics->currentPage() === $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $c_server_electrics->url($page) }}">{{ $page }}</a>
            </li>
        @endforeach
        <li class="page-item {{ $c_server_electrics->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $c_server_electrics->nextPageUrl() }}" aria-disabled="{{ $c_server_electrics->hasMorePages() ? 'false' : 'true' }}">Next</a>
        </li>
    </ul>
</nav>
