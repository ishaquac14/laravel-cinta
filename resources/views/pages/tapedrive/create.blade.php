@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
            <a href="{{ route('tapedrive.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
                <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
            </a>
        </div>

        <div class="mb-4 text-center">
            <h5>CREATE C/S BACKUP TAPEDRIVE</h5>
        </div>
        <hr>

        <form action="{{ route('tapedrive.store') }}" method="POST">
            @csrf
            <table class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th scope="col">Plan Media</th>
                        <th scope="col">Actual Media</th>
                        <th scope="col">Tape-ID</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="text-center">
                            <div class="text-center">
                                <select name="plan_media" class="form-select text-center" id="PlanSelect"
                                    contenteditable="true" required>
                                    <option value="" disabled selected>--- Plan Media ---</option>
                                    <option value="full_monthly">FULL MONTHLY</option>
                                    <option value="full_once">FULL ONCE</option>
                                    <option value="inc_daily">INC-DAILY</option>
                                </select>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="text-center">
                                <select name="actual_media" class="form-select text-center" id="ActualSelect"
                                    contenteditable="true" required>
                                    <option value="" disabled selected>--- Actual Media ---</option>
                                    <option value="full_monthly_act">FULL MONTHLY</option>
                                    <option value="full_once_act">FULL ONCE</option>
                                    <option value="inc_daily_act">INC-DAILY</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div>
                                <select name="tape_id" class="custom-select text-center" id="tape_id" required>
                                    <option value="" disabled selected>--- Tape ID ---</option>
                                    @foreach ($m_tapedrives as $m_tapedrive)
                                        <option value="{{ $m_tapedrive->tape_id }}">{{ $m_tapedrive->name }} -
                                            {{ $m_tapedrive->tape_id }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="text-center">
                                <select name="status" class="form-select text-center" id="StatusSelect"
                                    contenteditable="true" required>
                                    <option value="" disabled selected>--- Status ---</option>
                                    <option value="Active">Active</option>
                                    <option value="Finished">Finished</option>
                                    <option value="Failed">Failed</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="">
                <label for="exampleFormControlTextarea1" class="form-label"></label>
                <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="4" placeholder="Note"></textarea>
            </div>
            <div class="mt-4">
                <p><b>IMPORTANT:</b> If any failed, please email to: callcenter.fid@fujitsu.com</p>
            </div>
            <div class="mt-4 mb-5">
                <button class="btn btn-primary">SUBMIT</button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    {{-- <style>
        .custom-select {
            height: 2.25rem;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .custom-select:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style> --}}
    <style>
        /* Custom CSS to align Select2 with your custom select styling */
        .select2-container .select2-selection--single {
            height: 2.25rem;
            /* Match height with custom select */
            padding: 0.15rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            text-align: center;
            text-align: middle;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            color: #495057;
            /* padding: 0 2.25rem .1rem .75rem !important; */
        }

        .select2-container .select2-selection--single .select2-selection__arrow {
            height: 2.25rem;
            /* Match height with custom select */
            top: 50%;
            transform: translateY(-50%);
        }

        .select2-container--default .select2-selection--single:focus,
        .select2-container--default .select2-selection--single .select2-selection__rendered:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
@endpush

@push('scripts')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tape_id').select2({
                placeholder: "--- Tape ID ---",
                allowClear: true,
                // theme: "bootstrap-5"
            });
        });
    </script>
@endpush
