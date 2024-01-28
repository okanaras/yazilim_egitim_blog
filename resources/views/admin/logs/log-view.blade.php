<x-bootstrap.table :class="'table-striped table-hover'" :isResponsive="1">

    <x-slot:rows>
        @if($logtype == "App\Models\User")
            <tr>
                <td scope="col">Image</td>
                <td>
                    @if (!empty($data->image))
                        <img src="{{ asset($data->image) }}" height="60" data-aos="zoom-in"
                            data-aos-duration="1500">
                    @endif
                </td>
            </tr>
            <tr>
                <td scope="col">Name</td>
                <td>{{ $data->name }}</td>

            </tr>
            <tr>
                <td scope="col">Username</td>
                <td>{{ $data->username }}</td>

            </tr>
            <tr>
                <td scope="col">Email</td>
                <td>{{ $data->email }}</td>

            </tr>
            <tr>
                <td scope="col">Status</td>
                <td>
                    @if ($data->status)
                        <a href="javascript:void(0)" class="btn btn-success btn-sm">Aktif</a>
                    @else
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm">Pasif</a>
                    @endif
                </td>
            </tr>
            <tr>
                <td scope="col">Is Admin</td>
                <td>
                    @if ($data->is_admin)
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm">Admin</a>
                    @else
                        <a href="javascript:void(0)" class="btn btn-secondary btn-sm">User</a>
                    @endif
                </td>
            </tr>
        @elseif($logtype == "App\Models\Category")
            <tr>
                <td scope="col">Image</td>
                <td>
                    @if (!empty($data->image))
                        <img src="{{ asset($data->image) }}" height="60" data-aos="zoom-in"
                            data-aos-duration="1500">
                    @endif
                </td>
            </tr>
            <tr>
                <td scope="col">Name</td>
                <td>{{ $data->name }}</td>

            </tr>
            <tr>
                <td scope="col">Slug</td>
                <td>{{ $data->slug }}</td>

            </tr>
            <tr>
                <td scope="col">Description</td>
                <td>{{ $data->description }}</td>

            </tr>
            <tr>
                <td scope="col">Parent Category</td>
                <td>{{ $data->parent_category?->name }}</td>

            </tr>
            <tr>
                <td scope="col">User</td>
                <td>{{ $data->user?->name }}</td>

            </tr>
            <tr>
                <td scope="col">Order</td>
                <td>{{ $data->order }}</td>

            </tr>
            <tr>
                <td scope="col">Status</td>
                <td>
                    @if ($data->status)
                        <a href="javascript:void(0)" class="btn btn-success btn-sm">Aktif</a>
                    @else
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm">Pasif</a>
                    @endif
                </td>
            </tr>
            <tr>
                <td scope="col">Feature Status</td>
                <td>
                    @if ($data->feature_status)
                        <a href="javascript:void(0)" class="btn btn-success btn-sm">Aktif</a>
                    @else
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm">Pasif</a>
                    @endif
                </td>
            </tr>
            <tr>
                <td scope="col">Created Date</td>
                <td>{{ $data->created_at }}</td>
            </tr>
            <tr>
                <td scope="col">Updated Date</td>
                <td>{{ $data->updated_at }}</td>
            </tr>

        @elseif($logtype == "App\Models\Article")
            <tr>
                <td scope="col">Image</td>
                <td>
                    @if (!empty($data->image))
                        <img src="{{ asset($data->image) }}" height="60" data-aos="zoom-in"
                            data-aos-duration="1500">
                    @endif
                </td>
            </tr>
            <tr>
                <td scope="col">Title</td>
                <td>{{ $data->title }}</td>

            </tr>
            <tr>
                <td scope="col">Slug</td>
                <td>{{ $data->slug }}</td>

            </tr>
            <tr>
                <td scope="col">Body</td>
                <td>{{ $data->body }}</td>

            </tr>
            <tr>
                <td scope="col">Tags</td>
                <td>{{ $data->tags }}</td>

            </tr>
            <tr>
                <td scope="col">Status</td>
                <td>
                    @if ($data->status)
                        <a href="javascript:void(0)" class="btn btn-success btn-sm">Aktif</a>
                    @else
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm">Pasif</a>
                    @endif
                </td>
            </tr>
            <tr>
                <td scope="col">View Count</td>
                <td>{{ $data->view_count }}</td>

            </tr>
            <tr>
                <td scope="col">Like Count</td>
                <td>{{ $data->like_count }}</td>

            </tr>
            <tr>
                <td scope="col">Publish Date</td>
                <td>{{ $data->publish_date }}</td>

            </tr>
            <tr>
                <td scope="col">User</td>
                <td>{{ $data->user?->name }}</td>

            </tr>

        @elseif($logtype == "App\Models\Settings")
            <tr>
                <td scope="col">Logo</td>
                <td>
                    @if (!empty($data->logo))
                        <img src="{{ asset($data->logo) }}" height="60" data-aos="zoom-in"
                            data-aos-duration="1500">
                    @endif
                </td>
            </tr>
            <tr>
                <td scope="col">Category Default Image</td>
                <td>
                    @if (!empty($data->category_default_image))
                        <img src="{{ asset($data->category_default_image) }}" height="60" data-aos="zoom-in"
                            data-aos-duration="1500">
                    @endif
                </td>
            </tr>
            <tr>
                <td scope="col">Article Default Image</td>
                <td>
                    @if (!empty($data->article_default_image))
                        <img src="{{ asset($data->article_default_image) }}" height="60" data-aos="zoom-in"
                            data-aos-duration="1500">
                    @endif
                </td>
            </tr>
            <tr>
                <td scope="col">Default Comment Profile Image</td>
                <td>
                    @if (!empty($data->default_comment_profile_image))
                        <img src="{{ asset($data->default_comment_profile_image) }}" height="60" data-aos="zoom-in"
                            data-aos-duration="1500">
                    @endif
                </td>
            </tr>

        @endif

    </x-slot:rows>
</x-bootstrap.table>
