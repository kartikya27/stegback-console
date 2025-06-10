@extends('PanelPulse::admin.layout.header')
@section('title', 'Category | ' . env('APP_NAME'))
@section('style')
    <style>
        .admin-menu.settings {
            background-color: #eaeaea;
            border-left: 5px solid black;
            color: black;
        }

        .tree {
            --spacing: 1.5rem;
            --radius: 10px;
        }

        .tree li {
            display: block;
            position: relative;
            padding-left: calc(2 * var(--spacing) - var(--radius) - 2px);
        }

        .tree ul {
            margin-left: calc(var(--radius) - var(--spacing));
            padding-left: 0;
        }

        .tree ul li {
            border-left: 2px solid #ddd;
        }

        .tree ul li:last-child {
            border-color: transparent;
        }

        .tree ul li::before {
            content: '';
            display: block;
            position: absolute;
            top: calc(var(--spacing) / -2);
            left: -2px;
            width: calc(var(--spacing) + 2px);
            height: calc(var(--spacing) + 1px);
            border: solid #ddd;
            border-width: 0 0 2px 2px;
        }

        .tree summary {
            display: block;
            cursor: pointer;
        }

        .tree summary::marker,
        .tree summary::-webkit-details-marker {
            display: none;
        }

        .tree summary:focus {
            outline: none;
        }

        .tree summary:focus-visible {
            outline: 1px dotted #000;
        }

        .tree li::after,
        .tree summary::before {
            content: '';
            display: block;
            position: absolute;
            top: calc(var(--spacing) / 2 - var(--radius));
            left: calc(var(--spacing) - var(--radius) - 1px);
            width: calc(2 * var(--radius));
            height: calc(2 * var(--radius));
            border-radius: 50%;
            background: #ddd;
        }


        .tree details[open]>summary::before {
            background-position: calc(-2 * var(--radius)) 0;
        }


        .tree li {
            padding-left: calc(1.5rem + 16px); /* Tweak spacing here */
            margin-bottom: 8px; /* Adjust vertical spacing */
        }
        .tree summary:hover a {
            visibility: visible;
        }

        .tree summary a {
            visibility: hidden;
        }
    </style>
@endsection
@section('content')

<div class="container">
    <h1 class="heading1">Categories</h1>
        <div class="container info-cont p-5">
        <ul class="tree">
            @if(!empty($categories))
                @foreach($categories as $category)
                    @include('PanelPulse::admin.category.partials.tree_item', ['category' => $category])
                @endforeach
            @endif
        </ul>
    </div>
</div>

@endsection
@section('scriptContent')
@endsection
