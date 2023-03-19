<tr>
    <td colspan="{{ $numCol }}">
        <div class = "alert alert-warning">
            @isset($message)
                {{$message}}
            @else
                No record found
            @endisset
        </div>

    </td>
</tr>

