
<li class="nav-item" style="min-width: 500px">
    <div class="navbar-search col-xl-12">
    <input class="form-control form-control-navbar typeahead" type="search" name="query" data-provide="typeahead"
                    placeholder="Pesquise pelo nome ou CNPJ">

    </div>
</li>

@pushonce('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
    <script>
        $(function() {

            let route = "{{ route('clients.autocomplete') }}";
            $('.typeahead').typeahead({
                display: 'value',
                highlight: true,
                minLength: 3,
                source: function(query, process) {
                    console.log(process)
                    return $.get(route, {
                        query: query
                    }, function(data) {
                        console.log(data)
                        process($.map(data, function(item) {

                            // return item;
                            return {
                                id: item.id,
                                name: item.document + ' - ' + item.name,
                                toString: function() {
                                    return JSON.stringify(this);
                                },
                                toLowerCase: function() {
                                    return this.name.toLowerCase();
                                },
                                indexOf: function(string) {
                                    return String.prototype.indexOf.apply(
                                        this
                                            .name, arguments);
                                },
                                replace: function(string) {
                                    return String.prototype.replace.apply(
                                        this
                                            .name, arguments);
                                }
                            }
                        }));
                    });
                },
                templates: {
                    notFound: function(data) {

                        return '<div class="tt-no-results">Sorry, no results found for query: <strong>' +
                            data.query + '</strong></div>';
                    }
                },
                afterSelect: function(item) {
                    let id = item.id
                    {{--let url = '{{ route("adm.clients.show", ":id") }}';--}}
                    {{--url = url.replace(':id', id);--}}
                    {{--window.location.href = url--}}

                },

            });
        });
    </script>
@endpushonce
