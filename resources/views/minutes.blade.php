<x-layouts.app>
  <div class="w-full bg-teal-500 p-10">
    <div class="flex items-start justify-between w-10/12 mx-auto">
      <img src="/images/coat-of-arms.png" alt="" class="w-20 h-20">
      <div class="w-full text-center">
        <h2 class="text-3xl font-bold">SUNYANI MUNICIPAL ASSEMBLY</h2>
        <h3 class="text-2xl font-bold">PHYSICAL PLANNING DEPARTMENT</h3>
      </div>
      <img src="/images/coat-of-arms.png" alt="" class="w-20 h-20">
    </div>

    <div class="w-10/12 mt-10 mx-auto">
      <h4 class="text-xl font-bold text-center mb-8">MINUTES OF TECHNICAL SUB-COMMITTEE MEETING</h4>

      <div class="text-left mb-10">
        <table>
          <tbody>
            <tr>
              <th>Date: </th>
              <td>Wednesday, 26th June 2025</td>
            </tr>
            <tr>
              <th>Time: </th>
              <td>9:00am</td>
            </tr>
            <tr>
              <th>Venue: </th>
              <td>Physical Planning Department Conference Room, Sunyani Municipal Assembly</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="space-y-8">
        <section class="mb-8">
          <h4 class="text-base font-bold uppercase">
            <span>1.0</span>
            <span>Attendance</span>
          </h4>
        </section>

        @foreach ($record['content'] as $content)
        <section>
          <h4 class="text-base font-bold uppercase">
            <span>{{ $loop->index + 2 . '.0' }}</span>
            <span>{{ $content['title'] }}</span>
          </h4>

          {!! $content['contents'] !!}
        </section>
        @endforeach
      </div>

      <div class="flex justify-between pt-4 mt-8 border-t border-yellow-300">
        <div class="">
          <h5 class="font-semibold mb-3">Recorded by: </h5>
          <div class="">..........................................................</div>
          <p class="">Author Name</p>
          <p class="">Secretary</p>
          <p class="">Physical Planning Department</p>
        </div>

        <div class="">
          <h5 class="font-semibold mb-3">Approved by: </h5>
          <div class="">..........................................................</div>
          <p class="">Author Name</p>
          <p class="">Chairman</p>
          <p class="">Physical Planning Department</p>
        </div>

      </div>
    </div>
    </x-layouts>
  </div>
