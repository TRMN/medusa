@component('vendor.mail.html.message')
The following individuals have qualified for the indicated SWP for {{$swpReport['report_date']}}

@component('mail::table')
| Name | Member ID | SWP Type |
|------|:-----------:|:----------:|
@if (!empty($swpReport['ESWP']) || !empty($swpReport['OSWP']))
@foreach($swpReport['ESWP'] as $line)
| {{App\Models\User::getUserByMemberId($line->member_id)->getFullName()}} | {{$line->member_id}} | {{$line->award}}|
@endforeach
@foreach($swpReport['OSWP'] as $line)
| {{App\Models\User::getUserByMemberId($line->member_id)->getFullName()}} | {{$line->member_id}} | {{$line->award}}|
@endforeach
@else
No SWP qualifications for {{$swpReport['report_date']}}
@endif
@endcomponent

@endcomponent
