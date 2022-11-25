<nav class="pagination" role="navigation" aria-label="pagination">
    <a class="pagination-previous" href={{ route("list", ["page_number" => ($cur_page_number>1) ? $cur_page_number-1 : 1]) }}>Previous</a>
    <a class="pagination-next" href={{ route("list", ["page_number" => ($cur_page_number<$total_pages) ? $cur_page_number+1 : $total_pages]) }}>Next page</a>
    <ul class="pagination-list">
      @for ($i=1; $i<=$total_pages; $i++)
      <li>
        <a class="pagination-link @if ($cur_page_number == $i) is-current @endif" 
           aria-label={{ "Page " . $i }}
           href={{ route("list", ["page_number" => $i]) }}>{{ $i }}</a>
      </li>
      @endfor
    </ul>
</nav>