<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>设备注册</title>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden; /* ✅ 禁止上下左右滚动 */
            background: linear-gradient(135deg, #007bff 0%, #339dff 100%);
            font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", "PingFang SC", "Segoe UI", Roboto, Arial, sans-serif;
        }

        .center-wrapper {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 500px;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
        }

        .info-label {
            font-weight: 600;
            color: #555;
        }

        .info-value {
            font-size: 1.1rem;
            color: #000;
            word-break: break-all;
        }
    </style>
</head>
<body>
<div class="center-wrapper">
    <div class="card p-4 text-center bg-white">
        <h4 class="mb-3 text-primary">设备注册</h4>
        <p class="text-muted mb-4">请确认以下设备信息并点击按钮</p>

        <div class="row text-start">
            <div class="col-12 col-md-12 mb-md-0">
                <div class="info-label">序列号</div>
                <div class="info-value" id="serial">{{ $Serial }}</div>
            </div>
        </div>

        <div class="d-grid mt-4">
            <button id="registerBtn" class="btn btn-primary btn-lg">注册设备</button>
        </div>

        <p class="text-muted small mt-3 mb-0">Apple MDM 设备注册页面</p>
    </div>
</div>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>

<script>
    // 从 URL 获取参数
    function getParam(name) {
        const url = new URL(window.location.href);
        return url.searchParams.get(name);
    }

    function downloadBlob(blob, filename) {
        const link = document.createElement('a');
        const url = window.URL.createObjectURL(blob);
        link.href = url;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        link.remove();
        window.URL.revokeObjectURL(url);
    }

    $(function () {

        const message = getParam('message') || '';

        $('#registerBtn').on('click', function () {
            const btn = $(this);
            btn.prop('disabled', true).text('注册中...');

            $.ajax({
                url: '/enrollment',
                method: 'POST',
                data: {
                    message: message,
                    '_token': '{{ csrf_token() }}'
                },
                success: function (data, status, xhr) {
                    // 获取文件名
                    const disposition = xhr.getResponseHeader('Content-Disposition');
                    let fileName = 'device_profile.mobileconfig';
                    if (disposition && disposition.indexOf('filename=') !== -1) {
                        fileName = decodeURIComponent(disposition.split('filename=')[1].replace(/"/g, ''));
                    }

                    // 获取 Content-Type
                    let contentType = xhr.getResponseHeader('Content-Type') || 'application/octet-stream';

                    // 如果 data 是字符串，则转成 blob
                    let blob;
                    if (data instanceof Blob) {
                        blob = data;
                    } else if (typeof data === 'string') {
                        blob = new Blob([data], { type: contentType });
                    } else {
                        // 其它情况，强制转换为 blob
                        blob = new Blob([JSON.stringify(data)], { type: contentType });
                    }

                    downloadBlob(blob, fileName);
                    btn.prop('disabled', false).text('注册设备');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    btn.prop('disabled', false).text('注册设备');

                    // 尝试解析 JSON 错误
                    let msg = '设备注册失败，请稍后重试！';
                    try {
                        const contentType = jqXHR.getResponseHeader('Content-Type') || '';
                        if (contentType.includes('application/json')) {
                            const json = JSON.parse(jqXHR.responseText);
                            if (json.message) msg = json.message;
                        }
                    } catch(e) {
                        console.error('无法解析错误JSON', e);
                    }
                    alert(msg);
                }
            });
        });
    });
</script>
</body>
</html>