@extends('layouts/base')

@section('title')
  Update database
@endsection

@section('content')
  <div class="container">
    <h1 class="mt-5 mb-3">Update database:</h1>

    <form action="{{ route('update') }}" method="post">

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @csrf
      <div class="mb-3">
        <label for="formFile" class="form-label">Csv file for update database (does not work, test data will be
          loaded)</label>
        <input name="file" class="form-control disabled" type="file" id="formFile" disabled>
      </div>

      <button type="submit" class="btn btn-warning">Update</button> &nbsp;
      <- Click me for load test data </form>


        <table class="table mt-5">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Внешний код</th>
              <th scope="col">Номер</th>
              <th scope="col">Название</th>
              <th scope="col">Статус</th>
              <th scope="col">Дата изм.</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tenders as $t)
              <tr>
                <th scope="row">{{ $t->id }}</th>
                <td>{{ $t->code }}</td>
                <td>{{ $t->number }}</td>
                <td>{{ $t->name }}</td>
                <td>{{ $t->status }}</td>
                <td>{{ $t->updated_at }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

  </div>
@endsection
