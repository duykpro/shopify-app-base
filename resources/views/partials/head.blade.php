<title>{{ @$pageTitle }}</title>

<link rel="stylesheet" href="https://sdks.shopifycdn.com/polaris/latest/polaris.css" />

<script type="text/javascript" src="https://code.jquery.com/jquery.min.js"></script>

<script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
<script type="text/javascript">
ShopifyApp.init({
  apiKey: '{{ config('shopify.key') }}',
  shopOrigin: 'https://{{ $request->query('shop') }}'
});
</script>