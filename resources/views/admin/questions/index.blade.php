@extends('layouts.app')

@section('content')
    @include('layouts.header-admin')
    <div class="container" style="max-width: 1200px; margin-top: 110px;">
        <div class="d-flex justify-content-between align-items-end  mb-4">
            <h1 class="mb-0">Популярні запитання</h1>
            <a href="{{ route('admin.questions.create') }}" class="btn btn-success" style="margin-left: 140px;">
                <i class="fas fa-plus"></i> Додати нове запитання
            </a>
            <div>
                <div class="input-group" style="width: 300px;">
                    <input type="text" class="form-control" id="search" placeholder="Пошук по запитанню">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div id="no-results" class="alert alert-info" style="display: none; text-align: center;">
            Знижки не знайдено.
        </div>

        <div class="table-responsive" style="max-height: 655px; overflow-y: auto;">
            <table class="table table-bordered" style="background-color: #ffffff;">
                <thead class="thead-light">
                <tr>
                    <th style="min-width: 150px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(0)">
                        Запитання <i id="sortIcon0" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 100px; position: sticky; top: 0; z-index: 1; cursor: pointer;"
                        onclick="sortTable(1)">
                        Відповідь <i id="sortIcon1" class="fas fa-sort"></i>
                    </th>
                    <th style="min-width: 105px; position: sticky; top: 0; z-index: 1;">
                        Дії
                    </th>
                </tr>
                </thead>
                <tbody id="question-table-body">
                @foreach($questions as $question)
                    <tr>
                        <td>{{ $question->question }}</td>
                        <td>{{ $question->answer }}</td>
                        <td>
                            <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.questions.destroy', $question) }}" method="POST"
                                  style="display:inline;" onsubmit="return confirmDelete('{{ $question->question }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        #question-table-body tr:hover {
            background-color: #f1f1f1;
            transition: background-color 0.2s ease;
            cursor: pointer;
        }
    </style>

    <script>

        function confirmDelete(discountName) {
            return confirm(`Ви дійсно хочете видалити питання "${discountName}"?`);
        }

        let sortOrder = {};

        function sortTable(columnIndex) {
            const table = document.getElementById("question-table-body");
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

            while (table.firstChild) {
                table.removeChild(table.firstChild);
            }

            rows.forEach(row => table.appendChild(row));

            updateSortIcons(columnIndex, ascending);
        }

        function updateSortIcons(columnIndex, ascending) {
            for (let i = 0; i < 5; i++) {
                const icon = document.getElementById(`sortIcon${i}`);
                if (i === columnIndex) {
                    icon.className = ascending ? "fas fa-sort-up" : "fas fa-sort-down";
                } else {
                    icon.className = "fas fa-sort";
                }
            }
        }

        function fetchDiscounts(query = '') {
            fetch(`{{ route('admin.questions.search') }}?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('question-table-body');
                    const noResults = document.getElementById('no-results');
                    tableBody.innerHTML = '';

                    if (data.questions.length === 0) {
                        noResults.style.display = 'block';
                    }
                    else {
                        noResults.style.display = 'none';
                        data.questions.forEach(question => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                            <td>${question.question}</td>
                            <td>${question.answer}</td>
                            <td>
                                <a href="/admin/questions/${question.id}/edit" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="/admin/questions/${question.id}" method="POST" style="display:inline;" onsubmit="return confirmDelete('${question.question}')">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 10px">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        `;
                            tableBody.appendChild(row);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching discounts:', error);
                });
        }

        document.getElementById('search').addEventListener('input', function () {
            const query = this.value;
            fetchDiscounts(query);
        });

    </script>
@endsection
