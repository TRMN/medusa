@if (count($crew) > 0 && (Auth::user()->getPrimaryAssignmentId() == $detail->id || Auth::user()->getSecondaryAssignmentId() == $detail->id || $permsObj->hasPermissions(['VIEW_MEMBERS']) || in_array(Auth::user()->duty_roster,$detail->getChapterIdWithParents()) === true))
        <div class="row padding-5">
            <div class="small-2 columns Incised901Light">
                Crew Roster:
            </div>
            <div class="small-10 columns Incised901Light">
                <table id="crewRoster" class="compact row-border" width="75%">
                    <thead>
                    <tr>
                        <th<Chapter</th>
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
                        <td></td>
                        <td><a href="{{ route('user.show', [$member->_id]) }}">{{ $member->last_name }}{{ !empty($member->suffix) ? ' ' . $member->suffix : '' }}, {{ $member->first_name }}{{ isset($member->middle_name) ? ' ' . $member->middle_name : '' }}</a></td>
                        <td>{{ $member->getGreeting() }}</td>
						<td>{{is_null($tig = $member->getTimeInGrade())?'N/A':$tig}}</td>
                        <td>{{ $member->getBilletForChapter($detail->id) }}</td>
                        <td>{{$member->branch}}</td>
                    </tr>
                @endforeach
                </tbody>
                    <tfoot>
                    <tr>
                        <th>Chapter</th>
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
    @endif