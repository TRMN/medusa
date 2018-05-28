<table class="trmnUserTable-{{$branch}} compact row-border">
    <thead>
    <tr>
        <th class="text-center"><span class="fa fa-star red" data-toggle="tooltip"
                                      title="New Exams Posted">&nbsp;</span></th>
        <th class="text-center">Rank</th>
        <th class="text-center">Time in Grade</th>
        <th class="text-center">Name</th>
        <th class="text-center">Member ID</th>
        <th class="text-center">Email</th>
        <th class="text-center">Unit</th>
        <th class="text-center">@if($branch == 'Bosun')
                Branch
            @else
                Registration<br/>Date
            @endif
        </th>
        <th class="text-center nowrap">Actions</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th class="text-center"><span class="fa fa-star red" data-toggle="tooltip"
                                      title="New Exams Posted">&nbsp;</span></th>
        <th class="text-center">Rank</th>
        <th class="text-center">Time in Grade</th>
        <th class="text-center">Name</th>
        <th class="text-center">Member ID</th>
        <th class="text-center">Email</th>
        <th class="text-center">Unit</th>
        <th class="text-center">@if($branch == 'Bosun')
                Branch
            @else
                Registration<br/>Date
            @endif
        </th>
        <th class="text-center nowrap">Actions</th>
    </tr>
    </tfoot>
</table>

