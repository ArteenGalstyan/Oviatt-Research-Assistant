<section class="panel important">
    <h2>Log Statistics</h2>
    <table>
        <tr>
            <th>Host</th>
            <th>Info</th>
            <th>Debug</th>
            <th>Notice</th>
            <th>Warning</th>
            <th>Error</th>
            <th>Total</th>
        </tr>
        @foreach(AdminController::log_statistics_overview() as $host => $host_stats)
            <tr>
                <td>{{$host}}</td>
                <td>{{$host_stats['.INFO']}}</td>
                <td>{{$host_stats['.DEBUG']}}</td>
                <td>{{$host_stats['.NOTICE']}}</td>
                <td>{{$host_stats['.WARNING']}}</td>
                <td>{{$host_stats['.ERROR']}}</td>
                <td>{{$host_stats['.TOTAL']}}</td>
            </tr>
        @endforeach
    </table>
</section>
