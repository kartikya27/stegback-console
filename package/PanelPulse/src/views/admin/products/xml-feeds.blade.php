<rss xmlns:g="http://base.google.com/ns/1.0" xmlns:c="http://base.google.com/cns/1.0" version="2.0">
    <channel>
        <title>
            <![CDATA[ Stegback Marketplace ]]>
        </title>
        <link>
        <![CDATA[ https://stegback.de ]]>
        </link>
        <description>
            <![CDATA[ CTX Feed - This product feed is generated with the CTX Feed - WooCommerce Product Feed Manager plugin by WebAppick.com. For all your support questions check out our plugin Docs on https://webappick.com/docs or e-mail to: support@webappick.com ]]>
        </description>
        @foreach ($products as $product)
            {{-- @dd() --}}
            <item>
                
                <g:id>{{ $product->product_reference_id }}</g:id>
                
                <g:title>{{ $product->descriptions->first()?->product_name }}</g:title>
                
                <g:item_group_id>{{ $product->product_reference_id }}</g:item_group_id>
                
                <link>https:://stegback.de/product/{{$product['sku']}}/sp/{{ (new CommonHelper)->encryptValue($product['identifier_value']) }}?p_ref_i={{ base64_encode($product['identifier_type']) }}</link>


                <g:product_type>Balkonkraftwerk &gt; Bestseller &gt; Balkonkraftwerk Speicher</g:product_type>
                
                <g:google_product_category>{{ $product->product_categories()?->first()->name }}</g:google_product_category>
                
                <g:image_link>{{ $product->images->first()?->main_image }}</g:image_link>
                
                <g:condition>new</g:condition>
                
                <g:availability>in_stock</g:availability>
                
                <g:price>{{ (new CommonHelper)->price($product->prices->first()?->regular_price) }} EUR</g:price>
                
                <g:mpn>{{ $product->sku }}</g:mpn>
                
                <g:brand>Stegback</g:brand>
                
                <g:canonical_link>https:://stegback.de/product/{{$product['sku']}}/sp/{{ (new CommonHelper)->encryptValue($product['identifier_value']) }}?p_ref_i={{ base64_encode($product['identifier_type']) }}</g:canonical_link>
                
                @foreach ($product->images->first()?->gallery_image as $image)
                    <g:additional_image_link>{{ $image }}</g:additional_image_link>
                @endforeach
                <g:gtin></g:gtin>
                <g:identifier_exists>yes</g:identifier_exists>
                <g:description> {!! htmlspecialchars(strip_tags($product->descriptions->first()?->short_description)) !!}</g:description>
            </item>
        @endforeach
    </channel>
</rss>
