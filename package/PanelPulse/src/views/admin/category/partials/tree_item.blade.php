<li>
    @if(!empty($category['children']))
        <details {{ $loop->depth === 1 ? 'open' : '' }}>
            <summary>{{ $category['name'] }}
                <a href="{{route('category.edit',[$category['id'],$category['slug']])}}"><i class="fas fa-pen text-secondary small pl-2"></i></a>
            </summary>
            <ul>
                @foreach($category['children'] as $child)
                    @include('PanelPulse::admin.category.partials.tree_item', ['category' => $child])
                @endforeach
            </ul>
        </details>
    @else
    <details>
        <summary>
        {{ $category['name'] }}
        <a href="{{route('category.edit',[$category['id'],$category['slug']])}}"><i class="fas fa-pen text-secondary small pl-2"></i></a>
        </summary>
    </details>
    @endif
</li>
