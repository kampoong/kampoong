<div wire:init="getBalanceAllTimeSummary">
    @if ($isLoading)
        <div class="loading-state text-center">
            <img src="{{ asset('images/spinner.gif') }}" alt="Data loading spinner">
        </div>
    @else
        <table class="table table-sm mb-0">
            <thead>
                <tr>
                    <th>{{ __('app.table_no') }}</th>
                    <th class="text-left">{{ __('time.month') }}</th>
                    <th class="text-right">{{ __('transaction.income') }}</th>
                    <th class="text-right">{{ __('transaction.spending') }}</th>
                    <th class="text-right">{{ __('transaction.balance') }}</th>
                </tr>
                <tr class="">
                    <th>&nbsp;</th>
                    <th colspan="3">{{ __('transaction.start_balance') }}</th>
                    <th class="text-right">{{ format_number($startingBalance) }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($balanceAllTimeSummary as $yearMonth => $balanceSummary)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>
                            @if ($isForPrint)
                                {{ $balanceSummary['month_name'].' '.$balanceSummary['year'] }}
                            @else
                                {{ link_to_route('reports.finance.dashboard', $balanceSummary['month_name'].' '.$balanceSummary['year'], [
                                    'start_date' => $yearMonth.'-01',
                                    'end_date' => Carbon\Carbon::parse($yearMonth.'-10')->format('Y-m-t'),
                                ]) }}
                            @endif
                        </td>
                        <td class="text-right text-nowrap" style="color: {{ config('kampoong.income_color') }}">{{ format_number($balanceSummary['income']) }}</td>
                        <td class="text-right text-nowrap" style="color: {{ config('kampoong.spending_color') }}">{{ format_number($balanceSummary['spending']) }}</td>
                        @php
                            $typeCode = $balanceSummary['balance'] >= 0 ? 'income' : 'spending';
                        @endphp
                        <td class="text-right text-nowrap" style="color: {{ config('kampoong.'.$typeCode.'_color') }}">
                            {{ format_number($balanceSummary['balance']) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                @if ($balanceAllTimeSummary->count() > 1)
                    <tr>
                        <th>&nbsp;</th>
                        <th>{{ __('app.total') }}</th>
                        <th class="text-right">{{ format_number($balanceAllTimeSummary->sum('income')) }}</th>
                        <th class="text-right">{{ format_number($balanceAllTimeSummary->sum('spending')) }}</th>
                        <th class="text-right">{{ format_number($balanceAllTimeSummary->sum('balance')) }}</th>
                    </tr>
                @endif
                <tr>
                    <th>&nbsp;</th>
                    <th colspan="3">{{ __('transaction.end_balance') }}</th>
                    <th class="text-right">{{ format_number($startingBalance + $balanceAllTimeSummary->sum('balance')) }}</th>
                </tr>
            </tfoot>
        </table>
    @endif
</div>
