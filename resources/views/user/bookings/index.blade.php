@extends('layouts.app')

@section('content')

<div class="booking-page">

  <h4 class="page-title">Booking Saya</h4>

  <div class="card booking-card shadow-sm">
    <div class="card-body">

      <table class="table table-bordered align-middle table-custom">
        <thead>
          <tr>
            <th>Properti</th>
            <th>Tanggal Mulai</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>
        @forelse($bookings as $b)
          <tr>
            <td>
              <div class="property-name">
                {{ $b->property->name ?? '-' }}
              </div>
              <small class="property-location">
                {{ $b->property->city ?? '' }},
                {{ $b->property->province ?? '' }}
              </small>
            </td>

            <td>{{ $b->start_date }}</td>

            <td>
              @if($b->status == 'pending')
                <span class="badge badge-warning">Menunggu</span>
              @elseif($b->status == 'approved')
                <span class="badge badge-success">Diterima</span>
              @else
                <span class="badge badge-danger">Ditolak</span>
              @endif
            </td>

            <td>
              <a href="{{ route('user.property.show', $b->property_id) }}"
                 class="btn btn-primary btn-sm">
                Detail
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center empty-state">
              Belum ada booking.
            </td>
          </tr>
        @endforelse
        </tbody>

      </table>

    </div>
  </div>

</div>

@endsection
