@extends('layouts.app')

@section('content')
    <div class="container" style="max-width: 1400px;">
        <div style="display: flex; align-items: center; margin-bottom: 30px;">
            <h1 style="margin-right: 30px;">Товари для замовлення №{{ $order->id }}</h1>
            <a href="" class="btn btn-dark me-2" style="width: 220px; margin-left: auto; white-space: nowrap;">
                <i class="fas fa-file-alt"></i> Сформувати звіт
            </a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-info" style="white-space: nowrap; margin-left: 30px;">
                <i class="fas fa-arrow-left"></i> Назад до замовлень
            </a>
        </div>

        <div class="table-responsive" style="max-height: 685px; overflow-y: auto;">
            <table class="table table-bordered" style="background-color: #ffffff;">
                <thead class="thead-light">
                <tr>
                    <th style="min-width: 110px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(0)">
                        Артикул <i id="sortIcon0" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 100px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(1)">
                        Назва <i id="sortIcon1" class="fas fa-sort"></i>
                    </th>
                    <th style="position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(2)">
                        Категорія <i id="sortIcon2" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 100px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(3)">
                        Опис <i id="sortIcon3" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 100px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(4)">
                        Розмір <i id="sortIcon4" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 100px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(5)">
                        Інше <i id="sortIcon3" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 120px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(6)">
                        Кількість <i id="sortIcon5" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 100px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(7)">
                        Ціна <i id="sortIcon6" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 110px; position: sticky; top: 0; z-index: 1; cursor: pointer;" onclick="sortTable(8)">
                        Знижка <i id="sortIcon7" class="fas fa-sort"></i>
                    </th>
                    <th style="position: sticky; top: 0; z-index: 1;">
                        Зображення
                    </th>
                </tr>
                </thead>
                <tbody id="product-table-body">
                @foreach ($products as $productInOrder)
                    <tr>
                        <td>{{ $productInOrder->product->article }}</td>
                        <td>{{ $productInOrder->product->name }}</td>
                        <td>{{ $productInOrder->product->category->name }}</td>
                        <td>{{ $productInOrder->product->description }}</td>
                        <td>{{ $productInOrder->size }}</td>
                        <td>{{ $productInOrder->product->other }}</td>
                        <td>{{ $productInOrder->quantity }}</td>
                        <td>{{ $productInOrder->price }} грн</td>
                        <td>{{ $productInOrder->product->discount ? $productInOrder->product->discount->percentage . '%' : 'Немає' }}</td>
                        <td style="width: 100px;">
                            @if($productInOrder->product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $productInOrder->product->images[0]->image_url) }}" alt="{{ $productInOrder->product->name }}" style="width: 100px; height: auto;">
                            @else
                                <span>Немає зображення</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        let sortOrder = {};

        function sortTable(columnIndex) {
            const table = document.getElementById("product-table-body");
            const rows = Array.from(table.getElementsByTagName("tr"));

            let ascending = sortOrder[columnIndex] === "asc" ? false : true;
            sortOrder[columnIndex] = ascending ? "asc" : "desc";

            rows.sort((a, b) => {
                const cellA = a.getElementsByTagName("td")[columnIndex].innerText.toLowerCase();
                const cellB = b.getElementsByTagName("td")[columnIndex].innerText.toLowerCase();

                if (cellA < cellB) return ascending ? -1 : 1;
                if (cellA > cellB) return ascending ? 1 : -1;
                return 0;
            });

            table.innerHTML = "";
            rows.forEach(row => table.appendChild(row));

            updateSortIcons(columnIndex, ascending);
        }

        function updateSortIcons(columnIndex, ascending) {
            document.querySelectorAll("th i").forEach((icon, index) => {
                icon.classList.remove("fa-sort-up", "fa-sort-down");
                if (index === columnIndex) {
                    icon.classList.add(ascending ? "fa-sort-up" : "fa-sort-down");
                } else {
                    icon.classList.add("fa-sort");
                }
            });
        }
    </script>
@endsection



{{--     // ДЛЯ ВИВЕДЕННЯ ВСІХ ІСНУЮЧИХ КАРТИНОК--}}
                    {{--                    <td>--}}
{{--                        @if($productInOrder->product->images->isNotEmpty())--}}
{{--                            @foreach($productInOrder->product->images as $image)--}}
{{--                                <img src="{{ asset('storage/' . $image->image_url) }}" alt="{{ $productInOrder->product->name }}" style="width: 50px; height: auto; margin-right: 5px;">--}}
{{--                            @endforeach--}}
{{--                        @else--}}
{{--                            <span>Немає зображень</span>--}}
{{--                        @endif--}}
{{--                    </td>--}}

