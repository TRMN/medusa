
<div class="row padding-5">
    <div class="col-sm-2  Incised901Light">
        Subordinate Crew Roster:
    </div>
    <div class="col-sm-10  Incised901Light">
        <table id="subCrewRoster" class="compact row-border" width="75%">
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Rank</th>
                <th>Time in Grade</th>
                <th>Billet</th>
                <th>Branch</th>
            </tr>
            </thead>
        <tbody>
        @foreach($crew as $member)
            <tr>
                <td><a class="fa fa-list blue size-48" href="{!! route('user.show' , [$member->_id]) !!}" data-toggle="tooltip" title="{!! $member->getPrimaryAssignmentName() !!} <br> {!! $member->getSecondaryAssignmentName() !!} "></a></td>
                <td><a href="{!! route('user.show', [$member->_id]) !!}">{!! $member->last_name !!}{{ !empty($member->suffix) ? ' ' . $member->suffix : '' }}, {!! $member->first_name !!}{{ isset($member->middle_name) ? ' ' . $member->middle_name : '' }}</a></td>
                <td>{!! $member->getGreeting() !!}</td>
                <td>{!!is_null($tig = $member->getTimeInGrade())?'N/A':$tig!!}</td>
                <td>{!! $member->getBilletForChapter($detail->id) !!}</td>
                <td>{!!$member->branch!!}</td>
            </tr>
        @endforeach
        </tbody>
            <tfoot>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Rank</th>
                <th>Time in Grade</th>
                <th>Billet</th>
                <th>Branch</th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
