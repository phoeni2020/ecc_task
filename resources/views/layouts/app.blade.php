<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EEC Group Task</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
@include('includes.header')

<div class="container mt-4">
    @yield('content')
</div>

@include('includes.footer')
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let $searchInput = $('#search');
        let $suggestionsBox = $('#suggestions-box');

        // Trigger search suggestions as the user types
        $searchInput.on('keyup', function () {
            const query = $(this).val();

            if (query.length < 1) {
                $suggestionsBox.hide();
                return;
            }

            $.ajax({
                url: '{{ route('products.search.ajax') }}',
                type: 'GET',
                data: { query },
                success: function (data) {
                    renderSuggestions(data);
                },
                error: function () {
                    console.log('Error loading search suggestions');
                }
            });
        });

        // Render the suggestions dropdown
        function renderSuggestions(data) {
            if (!data.length) {
                $suggestionsBox.hide();
                return;
            }

            let htmlContent = '<ul class="suggestions-list">';
            data.forEach(function (item) {
                htmlContent += `
                <li class="suggestion-item" data-query="${item.title}">
                    ${item.title}
                </li>
            `;
            });
            htmlContent += '</ul>';
            $suggestionsBox.html(htmlContent).show();

            $('.suggestion-item').on('click', function () {
                $searchInput.val($(this).data('query'));
                performSearch($(this).data('query'));
                $suggestionsBox.hide();
            });
        }

        // Perform live search on query
        function performSearch(query) {
            $.ajax({
                url: '{{ route('products.search.ajax') }}',
                type: 'GET',
                data: { query },
                success: function (data) {
                    populateProductTable(data);
                },
                error: function () {
                    alert('Error loading search results');
                }
            });
        }

        // Dynamically populate the product table
        function populateProductTable(data) {
            let htmlContent = '';
            if (data.length > 0) {
                data.forEach(function (product) {
                    htmlContent += `
                    <tr>
                        <td>${product.id}</td>
                        <td>${product.title}</td>
                        <td>${product.description || 'N/A'}</td>
                        <td>${product.price || 'N/A'}</td>
                        <td>${product.quantity || 'N/A'}</td>
                        <td>
                            <a href="products/${product.id}" class="btn btn-info btn-sm">View</a>
                            <a href="products/${product.id}/edit" class="btn btn-warning btn-sm">Edit</a>
                            <form action="products/${product.id}" method="POST" class="d-inline-block">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                `;
                });
            } else {
                htmlContent = `
                <tr>
                    <td colspan="6" class="text-center text-muted">No products found.</td>
                </tr>
            `;
            }

            $('table tbody').html(htmlContent);
        }
    });
</script>




</body>
</html>
