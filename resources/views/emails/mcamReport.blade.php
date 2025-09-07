@component('vendor.mail.html.message')
    The following individuals have qualified for the indicated MCAM for {{$mcamReport['report_date']}}

@component('mail::table')
    | Name | Member ID | Award Number |
    |------|:-----------|:----------|
    @if (!empty($mcamReport['MCAM']) || !empty($mcamReport['MCAM']))
        @foreach($mcamReport['MCAM'] as $line)
            | {{App\User::getUserByMemberId($line->member_id)->getFullName()}} | {{$line->member_id}} | {{App\Utility\MedusaUtility::ordinal($line->qty)}}|
        @endforeach
    @else
        No MCAM qualifications for {{$mcamReport['report_date']}}
    @endif
@endcomponent

@endcomponent
