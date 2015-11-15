@extends('layout')

@section('pageTitle')
    Official Secrets Act Notice
@stop

@section('content')
    <hr>
    <h2 style="text-align: center;" class="trmn">THE OFFICIAL SECRETS ACT</h2>
    <hr>
    <p><em>Last Updated: November 13, 2015</em></p>

    <p>{{$greeting['rank']}} {{$greeting['last_name']}}, your access has changed. Please read the following and indicate your agreement to this policy.</p>

    <p>The information in this section can also be found in relevant Admiralty Orders</p>

    <p>The following Documents and Databases are to be considered classified Royal Manticoran Navy/Marine Corps/Army
        items and are not to be spread to members without rights to view them.</p>


    <ol>
        <li>The Online Membership Database – Only the Royal Council and BuComm Database Staff will have full access to
            this database. The Admiralty will have access based upon their needs. Fleet and Unit Commanders will get access
            to perform their duties. Certain Staff, such as the Staffs of BuPers, BuTrain and the JAG, will also be given
            access to the Database as dictated by their needs.
        </li>
        <li>Financial Documentations – Only the First Lord of the Admiralty, the Chancellor of the Exchequer, and the
            Seventh Space Lord (BuSup), and as necessitated by legal requirements, the Judge Advocate General, shall
            have access to this information.
        </li>
        <li>All Exams are controlled items and are covered by the Secrets Act. Completed answers or exams are not to be
            shared with any member who has not successfully completed that exam.
        </li>
        <li>Any additional Documents relating to membership records or member finances deemed to require extra
            protection to ensure the safety of our membership’s personal and financial information
        </li>
        <li>Any additional Documents or Systems voted on by the Admiralty (First Lord of the Admiralty & The Seven Space
            Lords), the Commandant of the Marine Corps, the Commandant of the Army and the High Admiral of the Grayson
            Space Navy. A vote of 8 out of 11 will be required to add a Document or System to the Official Secrets Act.
        </li>
    </ol>


    <p>Dissemination of any Documents, Databases or Systems covered by the Official Secrets Act is ground for immediate
        membership termination, with no refund of remaining pro-rated membership dues.</p>

    {{ Form::open(['route' => 'osa', 'method' => 'post']) }}
    {{ Form::hidden('id', Auth::user()->id) }}
    <div>
        {{ Form::checkbox('osa',1) }} I have read and agree to this policy
    </div>
    <div>
        <p><em>If you click "I do not agree", you will be logged out and will be unable to use Medusa until you agree.  For more information on why you must agree to this policy, contact <a href="mailto:bupers@trmn.org">The Fifth Space Lord</a></em> </p>
    </div>
    <div>
        <a class="button"
           href="{{ route('signout') }}">I do not agree</a> {{ Form::submit('I Agree', [ 'class' => 'button' ] ) }}
    </div>
    {{ Form::close() }}
@stop

