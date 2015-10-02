@extends('layout')

@section('pageTitle')
Billets List
@stop

@section('content')
    <div><h3 class="trmn">Billet List</h3></div>
    
    <table id="billetList" class="compact row-border">
        <thead>
            <tr>
                <td>Billet</td>
            </tr>
        </thead>
        <tbody>
        @foreach(Billet:all() as $billet)
            <tr>
                <td>(($billet))</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>Billet</td>
            </tr>
        </tfoot>
    </table>

@stop
