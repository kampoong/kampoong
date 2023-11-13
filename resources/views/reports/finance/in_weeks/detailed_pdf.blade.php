@extends('layouts.print')

@section('title', __('report.weekly', ['year_month' => $currentMonthEndDate->isoFormat('MMMM Y')]))

@section('content')
<htmlpageheader name="wpHeader">
    @include('reports.partials.letterhead')

    <h2 class="text-center strong">
        @if (isset(auth()->activeBook()->report_titles['finance_detailed']))
            {{ auth()->activeBook()->report_titles['finance_detailed'] }} - {{ $currentMonthEndDate->isoFormat('MMMM Y') }}
        @else
            {{ __('report.weekly') }} - {{ $currentMonthEndDate->isoFormat('MMMM Y') }}
        @endif
    </h2>
</htmlpageheader>

@foreach($groupedTransactions as $weekNumber => $weekTransactions)
<table class="table">
    <thead>
        <tr>
            <th class="text-center">{{ __('app.date') }}</th>
            <th>{{ __('transaction.transaction') }}</th>
            <th class="text-right">{{ __('transaction.income') }}</th>
            <th class="text-right">{{ __('transaction.spending') }}</th>
            <th class="text-right">{{ __('transaction.balance') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($weekTransactions as $dayName => $daysTransactions)
            @if ($dayName)
                <tr><td class="text-center strong">{{ strtoupper($dayName) }}</td><td colspan="4">&nbsp;</td></tr>
            @endif
            @foreach ($daysTransactions as $transaction)
            <tr class="{{ $transaction->is_strong ? 'strong' : '' }}">
                <td class="text-center">{{ $transaction->date }}</td>
                <td {{ $transaction->is_strong ? 'style=text-decoration:underline' : '' }} class="{{ $transaction->is_strong ? 'strong' : '' }}">
                    {{ $transaction->description }}
                </td>
                <td class="text-right {{ $transaction->is_strong ? 'strong' : '' }}">{{ $transaction->in_out ? format_number($transaction->amount) : '' }}</td>
                <td class="text-right {{ $transaction->is_strong ? 'strong' : '' }}">{{ !$transaction->in_out ? format_number($transaction->amount) : '' }}</td>
                <td class="text-center {{ $transaction->is_strong ? 'strong' : '' }}">&nbsp;</td>
            </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" class="text-right">{{ __('app.total') }}</th>
            <th class="text-right">
                @php
                    $incomeAmount = $weekTransactions->flatten()->sum(function ($transaction) {
                        return $transaction->in_out ? $transaction->amount : 0;
                    });
                @endphp
                {{ format_number($incomeAmount) }}
            </th>
            <th class="text-right">
                @php
                    $spendingAmount = $weekTransactions->flatten()->sum(function ($transaction) {
                        return $transaction->in_out ? 0 : $transaction->amount;
                    });
                @endphp
                {{ format_number($spendingAmount) }}
            </th>
            <th class="text-right">{{ format_number($incomeAmount - $spendingAmount) }}</th>
        </tr>
    </tfoot>
</table>
@if ($weekNumber != $groupedTransactions->keys()->last())
    <pagebreak />
@endif
@endforeach
@endsection

@section('style')
<style>
    @page {
        size: auto;
        margin-top: @if($showLetterhead) 170px; @else 100px; @endif
        margin-bottom: 20px;
        margin-left: 50px;
        margin-right: 50px;
        margin-header: 40px;
        margin-footer: 40px;
        header: html_wpHeader;
    }
</style>
@endsection
