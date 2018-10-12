<div class="select_document">
    <div class="view_style1">
        <form action="{{ $action }}" method="GET">
            <table>
                <colgroup>
                    <col style="width:20%;">
                    <col>
                </colgroup>
                <tbody>
                <tr>
                    <th>지점선택</th>
                    <td colspan="3" class="text-left">
                        @foreach ($currentUser->branches as $branch)
                            @php
                                $checked = ! request()->has('branches') || in_array($branch->id, request()->get('branches'));
                            @endphp
                            <div class="d-inline-block">
                                <label class="form-check-label">
                                    <input type="checkbox" name="branches[]" value="{{ $branch->id }}"{{ $checked ? ' checked' : '' }}> {{ $branch->name }}
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        @endforeach
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>