@extends('layout')

@section('pageTitle')
    CONFIDENTIALITY AND NON-DISCLOSURE AGREEMENT
@stop

@section('content')
    <hr>
    <h2 style="text-align: center;" class="trmn">CONFIDENTIALITY AND NON-DISCLOSURE AGREEMENT</h2>
    <hr>
    <p><em>Last Updated: November 16, 2015</em></p>

@if($showform === true)
    <p>{!!$greeting['rank']!!} {!!$greeting['last_name']!!}, your access has changed. Please read the following and indicate
        your agreement to this policy.</p>

    <p>By reading this document and agreeing to the policy (by clicking that you have read and agree below) you are
        acknowledging that you have been granted permission to view confidential information by The Royal Manticoran
        Navy (TRMN). By agreeing you acknowledge that you are bound by TRMN regulations (Admiralty Orders) on
        confidentiality. You further acknowledge that if you disseminate any information you have been granted without
        permission from the Judge Advocate General or the First Lord of the Admiralty that you will be subject to
        discipline up to and including revocation and denial of membership. Accidental dissemination of information may
        be cause for discipline at the discretion of the Royal Council depending on the circumstances regarding the
        dissemination.</p>

    <p>The following information is taken from the Official Secrets Act, which is the TRMN regulation regarding
        confidential information. By agreeing you acknowledge that it is your responsibility to follow this and any
        subsequent Admiralty Orders regarding confidentiality, regardless of whether or not this acknowledgment has been
        updated or you have been asked to accept again.</p>
@endif
    <h2 style="text-align: center;" class="trmn">THE OFFICIAL SECRETS ACT</h2>

    <p>The following Documents and Databases are to be considered classified Royal Manticoran Navy/Marine Corps/Army
        items and are not to be spread to members without rights to view them.</p>

    <ol>
        <li>The Online Membership Database – Only the Royal Council and BuComm Database Staff will have full access to
            this database. The Admiralty will have access based upon their needs. Fleet, Echelon and Unit Commanders
            will get access to perform their duties. Certain Staff, such as the Staffs of BuPers, BuTrain and the JAG,
            will also be given access to the Database as dictated by their needs.
        </li>
        <li>Financial Documentations – Only the First Lord of the Admiralty, the Chancellor of the Exchequer, and the
            Seventh Space Lord (BuSupp), and as necessitated by legal requirements, the Judge Advocate General, shall
            have access to this information
        </li>
        <li>All Exams are controlled items and are covered by the Secrets Act. Completed answers or exams are not to be
            shared with any member who has not successfully completed that exam.
        </li>
        <li>Any additional Documents relating to membership records or member finances deemed to require extra
            protection to ensure the safety of our membership’s personal and financial information
        </li>
        <li>Any Documents provided TRMN by BuNine, Words of Weber or David Weber’s representatives, and deemed as
            covered by the First Lord of the Admiralty and First Space Lord.
        </li>
        <li>Any additional Documents or Systems voted on by the Admiralty (First Lord of the Admiralty & The Seven Space
            Lords), the Commandant of the Marine Corps, the Marshal of the Army and the High Admiral of the Grayson
            Space Navy. A vote of 8 out of 11 will be required to add a Document or System to the Official Secrets Act.
        </li>
    </ol>

    <p>Any additional Documents or Systems voted on by the Admiralty (First Lord of the Admiralty & The Seven Space
        Lords), the Commandant of the Marine Corps, the Commandant of the Army and the High Admiral of the Grayson Space
        Navy. A vote of 8 out of 11 will be required to add a Document or System to the Official Secrets Act.</p>

    <p>Dissemination of any Documents, Databases or Systems covered by the Official Secrets Act is ground for immediate
        membership termination, with no refund of remaining pro-rated membership dues.</p>

    <p>The information in this section can also be found in relevant Admiralty Orders</p>
@if($showform === true)
    {!! Form::open(['route' => 'osa', 'method' => 'post']) !!}
    {!! Form::hidden('id', Auth::user()->id) !!}
    {!! Form::hidden('osa',1) !!}

    <p><em>By clicking "I Agree", you agee that you have read and understand this policy. If you click "I do not agree",
            you will be logged out and will be unable to use Medusa until you agree. For more information on why you
            must agree to this policy, contact <a href="mailto:bupers@trmn.org">The Fifth Space Lord</a> (BuPers)</em>
    </p>
    <div>
        <a class="btn btn-danger"
           href="{!! route('signout') !!}"><span class="fa fa-times"></span> I do not agree </a> <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> I Agree </button>
    </div>
    {!! Form::close() !!}
@endif
@stop