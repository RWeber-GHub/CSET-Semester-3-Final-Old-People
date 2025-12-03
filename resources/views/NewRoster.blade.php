@extends('layouts.app')

@section('title','New Roster')

@section('content')
    <div class="page-header">New / Edit Roster</div>

    <form method="POST" action="{{ route('roster.store') }}">
        @csrf

        <label>Select Date</label>
        <input type="date" name="date" value="{{ old('date', $date) }}" required>

        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:14px;margin-top:16px;">
            <div>
                <label>Supervisor</label>
                <select name="supervisor_id">
                    <option value="">-- none --</option>
                    @foreach($users as $u)
                        <option value="{{ $u->UserID }}" {{ optional($roster)->supervisor_id == $u->UserID ? 'selected' : '' }}>
                            {{ $u->Last_Name }}, {{ $u->First_Name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Doctor</label>
                <select name="doctor_id">
                    <option value="">-- none --</option>
                    @foreach($users as $u)
                        <option value="{{ $u->UserID }}" {{ optional($roster)->doctor_id == $u->UserID ? 'selected' : '' }}>
                            {{ $u->Last_Name }}, {{ $u->First_Name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Caregiver 1</label>
                <select name="caregiver1_id">
                    <option value="">-- none --</option>
                    @foreach($users as $u)
                        <option value="{{ $u->UserID }}" {{ optional($roster)->caregiver1_id == $u->UserID ? 'selected' : '' }}>
                            {{ $u->Last_Name }}, {{ $u->First_Name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Caregiver 2</label>
                <select name="caregiver2_id">
                    <option value="">-- none --</option>
                    @foreach($users as $u)
                        <option value="{{ $u->UserID }}" {{ optional($roster)->caregiver2_id == $u->UserID ? 'selected' : '' }}>
                            {{ $u->Last_Name }}, {{ $u->First_Name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Caregiver 3</label>
                <select name="caregiver3_id">
                    <option value="">-- none --</option>
                    @foreach($users as $u)
                        <option value="{{ $u->UserID }}" {{ optional($roster)->caregiver3_id == $u->UserID ? 'selected' : '' }}>
                            {{ $u->Last_Name }}, {{ $u->First_Name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Caregiver 4</label>
                <select name="caregiver4_id">
                    <option value="">-- none --</option>
                    @foreach($users as $u)
                        <option value="{{ $u->UserID }}" {{ optional($roster)->caregiver4_id == $u->UserID ? 'selected' : '' }}>
                            {{ $u->Last_Name }}, {{ $u->First_Name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Patient Group 1</label>
                <input type="text" name="patient_group1" value="{{ old('patient_group1', optional($roster)->patient_group1) }}">
            </div>

            <div>
                <label>Patient Group 2</label>
                <input type="text" name="patient_group2" value="{{ old('patient_group2', optional($roster)->patient_group2) }}">
            </div>

            <div>
                <label>Patient Group 3</label>
                <input type="text" name="patient_group3" value="{{ old('patient_group3', optional($roster)->patient_group3) }}">
            </div>

            <div>
                <label>Patient Group 4</label>
                <input type="text" name="patient_group4" value="{{ old('patient_group4', optional($roster)->patient_group4) }}">
            </div>
        </div>

        <div style="margin-top:18px;">
            <button class="btn btn-success" type="submit">Save Roster</button>
            <a href="{{ route('roster.index', ['date' => $date]) }}" class="btn btn-dark" style="margin-left:8px;">Cancel</a>
        </div>
    </form>
@endsection
