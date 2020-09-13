@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <ul class="nav nav-pills" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="deposits-tab" data-toggle="tab" href="#deposits" role="tab" aria-controls="deposits" aria-selected="true">@lang('messages.deposits')</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">@lang('messages.transactions')</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="deposits" role="tabpanel" aria-labelledby="deposits-tab">
              <table class="table table-bordered table-responsive-sm mt-3 table-sm">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">@lang('messages.invested_amount')</th>
                    <th scope="col">@lang('messages.percentage')</th>
                    <th scope="col">@lang('messages.status')</th>
                    <th scope="col">@lang('messages.accrue_times')</th>
                    <th scope="col">@lang('messages.created_at')</th>
                  </tr>
                </thead>
                <tbody>
                  @if(count($deposits) > 0)
                  @foreach($deposits as $deposit)
                  <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>{{ $deposit->invested_amount }}</td>
                    <td>{{ $deposit->percentage }}</td>
                    <td>{{ $deposit->status }}</td>
                    <td>{{ $deposit->accrue_times }}</td>
                    <td>{{ $deposit->created_at->diffForHumans() }}</td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <th scope="row">@lang('messages.no_deposits')</th>
                  </tr>
                  @endif

                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <table class="table table-bordered table-responsive-sm mt-3 table-sm">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">@lang('messages.type')</th>
                    <th scope="col">@lang('messages.amount')</th>
                    <th scope="col">@lang('messages.created_at')</th>
                  </tr>
                </thead>
                <tbody>
                  @if(count($transactions) > 0)
                  @foreach($transactions as $transaction)
                  <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>{{ $transaction->type }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->created_at->diffForHumans() }}</td>
                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          @lang('messages.replenishment')
        </div>
        <div class="card-body">
          <form action="{{ route('wallet.replenish') }}" method="post">
            <div class="form-group">
              <label for="amount">@lang('messages.amount')</label>
              <input type="number" name="amount" value="0.00" step="0.10" class="form-control" id="amount">
            </div>
            @csrf
            <button type="submit" class="btn btn-info text-light">@lang('messages.replenish')</button>
          </form>
        </div>
      </div>
      <div class="card mt-3">
        <div class="card-header">
          @lang('messages.derecognition')
        </div>
        <div class="card-body">
          <form action="{{ route('wallet.derecognise') }}" method="post">
            <div class="form-group">
              <label for="amount">@lang('messages.amount')</label>
              <input type="number" name="amount" value="0.00" step="0.10" class="form-control" id="amount">
            </div>
            @csrf
            <button type="submit" class="btn btn-info text-light">@lang('messages.derecognise')</button>
          </form>
        </div>
      </div>
      <div class="card mt-3">
        <div class="card-header">
          @lang('messages.investment')
        </div>
        <div class="card-body">
          <form action="{{ route('deposit.invest') }}" method="post">
            <div class="form-group">
              <label for="invested_amount">@lang('messages.invested_amount')</label>
              <input type="number" name="invested_amount" value="0.00" step="0.10" class="form-control" id="invested_amount">
            </div>
            <div class="form-group">
              <label for="percentage">@lang('messages.percentage')</label>
              <input type="number" name="percentage" value="20.0" class="form-control" id="amount" readonly>
            </div>
            @csrf
            <button type="submit" class="btn btn-info text-light">@lang('messages.invest')</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
