@extends('layouts.app')

@section('title','Roster')

@section('content')
    <div class="page-header">Roster</div>

    <form method="GET" action="{{ route('roster.index') }}" style="display:flex;align-items:center;gap:12px;margin-bottom:18px;">
        <label style="margin:0;">Date</label>
        <input type="date" name="date" value="{{ old('date',$date) }}">
        <button type="submit" class="btn btn-primary">View</button>

        @can('manage-roster')
            <a href="{{ route('roster.new', ['date' => $date]) }}" class="btn btn-dark" style="margin-left:8px;">New/Edit Roster</a>
        @endcan
    </form>

    <table>
        <thead>
            <tr>
                <th>Supervisor</th>
                <th>Doctor</th>
                <th>Caregiver1</th>
                <th>Caregiver2</th>
                <th>Caregiver3</th>
                <th>Caregiver4</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ optional($roster->supervisor)->First_Name ?? '—' }} {{ optional($roster->supervisor)->Last_Name ?? '' }}</td>
                <td>{{ optional($roster->doctor)->First_Name ?? '—' }} {{ optional($roster->doctor)->Last_Name ?? '' }}</td>
                <td>{{ optional($roster->cg1)->First_Name ?? '—' }} {{ optional($roster->cg1)->Last_Name ?? '' }}</td>
                <td>{{ optional($roster->cg2)->First_Name ?? '—' }} {{ optional($roster->cg2)->Last_Name ?? '' }}</td>
                <td>{{ optional($roster->cg3)->First_Name ?? '—' }} {{ optional($roster->cg3)->Last_Name ?? '' }}</td>
                <td>{{ optional($roster->cg4)->First_Name ?? '—' }} {{ optional($roster->cg4)->Last_Name ?? '' }}</td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td>{{ $roster->patient_group1 ?? '' }}</td>
                <td>{{ $roster->patient_group2 ?? '' }}</td>
                <td>{{ $roster->patient_group3 ?? '' }}</td>
                <td>{{ $roster->patient_group4 ?? '' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="muted-note">This page is accessed by Everyone.</div>

    <div style="margin-top:16px;font-size:0.9rem;color:#666;">
        Schema reference: <code>/mnt/data/a0cb25d1-2e82-4bdb-957f-12c5974ea4bc.png</code>
    </div>
@endsection
