@extends('gentelella.layout.main')
@section('main')
    <!-- page content -->
    <div class="">
        @include('gentelella.partials.page-tittle',['heading'=> 'Server #'.$server->id.' '.$server->label,'small' => 'Details','desc' => $server->desc])
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ $server->label }}</h2>
                        <div class="text-right">
                            <p class="btn btn-{{ ($server->status === "Powered ON") ? 'success' : 'danger' }}"
                               style="width: 100%; max-width: 150px;"> {{ $server->status }} </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <ul class="stats-overview">
                                <li>
                                    <span class="name"> CPU </span>
                                    <span class="value text-success text-wrap"> {{ $server->cpu }} </span>
                                </li>
                                <li>
                                    <span class="name"> Ram </span>
                                    <span class="value text-success text-wrap"> {{ $server->ram }} </span>
                                </li>
                                <li class="hidden-phone">
                                    <span class="name"> Storage </span>
                                    <span class="value text-success text-wrap"> {{ $server->storage }} </span>
                                </li>
                            </ul>
                            <ul class="stats-overview">
                                <li>
                                    <span class="name"> IP </span>
                                    <span class="value text-success text-wrap"> {{ $server->ip }} </span>
                                </li>
                                <li>
                                    <span class="name"> R-DNS </span>
                                    <span class="value text-success text-wrap"> {{ $server->rdns }} </span>
                                </li>
                                <li class="hidden-phone">
                                    <span class="name"> OS </span>
                                    <span class="value text-success text-wrap"> {{ $server->os }} </span>
                                </li>
                            </ul>
                            <ul class="stats-overview">
                                <li>
                                    <span class="name"> VNC Port </span>
                                    <span class="value text-success text-wrap"> {{ $server->vnc_port }} </span>
                                </li>
                                <li>
                                    <span class="name"> VNC Pass </span>
                                    <span class="value text-success text-wrap"> {{ $server->vnc_pass }} </span>
                                </li>
                                <li class="hidden-phone">
                                    <span class="name"> Created </span>
                                    <span class="value text-success text-wrap"> {{ $server->created_at->diffForHumans() }} </span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <h3 class="text-center green">
                                Server #{{ $server->id }} usage
                            </h3>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active @if($server->used_storage[9] < 20) progress-bar-primary @elseif($server->used_storage[9] >= 20 && $server->used_storage[9] <= 50) progress-bar-success @elseif($server->used_storage[9] > 50 && $server->used_storage[9] <= 70) progress-bar-warning @else progress-bar-danger @endif"
                                     role="progressbar" aria-valuenow="{{ $server->used_storage[9] }}"
                                     aria-valuemin="40" aria-valuemax="100"
                                     style="width: {{ $server->used_storage[9] }}%; min-width: 35%;">
                                    Storage: {{ $server->used_storage[9] }}%
                                </div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active @if($server->used_cpu[9] < 20) progress-bar-primary @elseif($server->used_cpu[9] >= 20 && $server->used_cpu[9] <= 50) progress-bar-success @elseif($server->used_cpu[9] > 50 && $server->used_cpu[9] <= 70) progress-bar-warning @else progress-bar-danger @endif"
                                     role="progressbar" aria-valuenow="{{ $server->used_cpu[9] }}" aria-valuemin="40"
                                     aria-valuemax="100" style="width: {{ $server->used_cpu[9] }}%; min-width: 35%;">
                                    CPU: {{ $server->used_cpu[9] }}%
                                </div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active @if($server->used_ram[9] < 20) progress-bar-primary @elseif($server->used_ram[9] >= 20 && $server->used_ram[9] <= 50) progress-bar-success @elseif($server->used_ram[9] > 50 && $server->used_ram[9] <= 70) progress-bar-warning @else progress-bar-danger @endif"
                                     role="progressbar" aria-valuenow="{{ $server->used_ram[9] }}" aria-valuemin="40"
                                     aria-valuemax="100" style="width: {{ $server->used_ram[9] }}%; min-width: 35%;">
                                    Storage: {{ $server->used_ram[9] }}%
                                </div>
                            </div>
                        </div>
                        <div class="x_content">
                            <!-- start project-detail sidebar -->
                            <div class="col-md-4 col-sm-4 col-xs-12">

                                <section class="panel">

                                    <div class="x_title">
                                        <h2 class="green">Manage Server</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="clearfix"></div>
                                        <div class="text-c enter mtop20">
                                            <a href="{{ action('ServerController@powerOn',['id'=>$server->id]) }}" class="btn btn-app action-button">
                                                <i class="fa fa-play"></i>
                                                Power On
                                            </a>
                                            <a href="{{ action('ServerController@powerOff',['id'=>$server->id]) }}" class="btn btn-app action-button">
                                                <i class="fa fa-pause"></i>
                                                Power Off
                                            </a>
                                            <a href="{{ action('ServerController@reboot',['id'=>$server->id]) }}" class="btn btn-app action-button">
                                                <i class="fa fa-repeat"></i>
                                                Reboot
                                            </a>
                                            <a href="{{ action('ServerController@rdns',['id'=>$server->id]) }}" class="btn btn-app action-button">
                                                <i class="glyphicon glyphicon-flash"></i>
                                                R-DNS
                                            </a>
                                            <a href="{{ action('ServerController@rename',['id'=>$server->id]) }}" class="btn btn-app action-button">
                                                <i class="fa fa-edit"></i>
                                                Rename
                                            </a>
                                            <a href="{{ action('ServerController@console',['id'=>$server->id]) }}" class="btn btn-app action-button">
                                                <i class="glyphicon glyphicon-wrench"></i>
                                                Console
                                            </a>
                                            <a href="{{ action('ServerController@delete',['id'=>$server->id]) }}" class="btn btn-app action-button">
                                                <i class="glyphicon glyphicon-trash"></i>
                                                Delete
                                            </a>
                                            <a href="javascript;" class="btn btn-app" data-toggle="modal" data-target=".logs-model">
                                                <i class="fa fa-bullhorn"></i>
                                                Logs
                                            </a>

                                            <div class="modal fade logs-model" tabindex="-1" role="dialog"
                                                 aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                            <h4 class="modal-title" id="myModalLabel">Recent
                                                                Activity</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div>
                                                                @if(!$server->logs->count())
                                                                    <h3>Logs are non-existing at the moment.</h3>
                                                                @else
                                                                    <ul class="messages">
                                                                        @foreach($server->logs as $log)
                                                                            <li>
                                                                                <div class="message_date">
                                                                                    <h3 class="date text-info">{{ $log->created_at->time() }}</h3>
                                                                                    <p class="month">{{ $log->created_at->diffForHumans() }}</p>
                                                                                </div>
                                                                                <div class="message_wrapper">
                                                                                    <h4 class="heading"> {{ $log->name }} </h4>
                                                                                    <blockquote
                                                                                            class="message"> {{ $log->desc }} </blockquote>
                                                                                </div>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            <!-- end of user messages -->
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div id="mainb" class="hidden-xs" style="height:350px;"></div>
                            </div>
                        </div>
                        <!-- end project-detail sidebar -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection

@section('css')
    <!-- iCheck -->
    <link href="/css/green.css" rel="stylesheet" />
    <link href="/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" />
    <link href="/css/pnotify.css" rel="stylesheet" />
    <link href="/css/pnotify.buttons.css" rel="stylesheet" />
    <link href="/css/pnotify.nonblock.css" rel="stylesheet" />
@endsection

@section('js')
    <script src="/js/bootstrap-progressbar.min.js"></script>
    <script src="/js/echarts.min.js"></script>
    <script src="/js/pnotify.js"></script>
    <script src="/js/pnotify.buttons.js"></script>
    <script src="/js/pnotify.nonblock.js"></script>

    <script>
        $('a.action-button').click(function (e) {
            e.preventDefault();
            $.post($(this).attr('href'),{
                'action': $(this).attr('data'),
                '_token' : '{{ csrf_token() }}',
            },function  (data, status){
                new PNotify($.parseJSON(data));
            });
        });
    </script>

    <!-- ECharts -->
    <script>
        var theme = {
            color: [
                '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
                '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
            ],

            title: {
                itemGap: 8,
                textStyle: {
                    fontWeight: 'normal',
                    color: '#408829'
                }
            },

            dataRange: {
                color: ['#1f610a', '#97b58d']
            },

            toolbox: {
                color: ['#408829', '#408829', '#408829', '#408829']
            },

            tooltip: {
                backgroundColor: 'rgba(0,0,0,0.5)',
                axisPointer: {
                    type: 'line',
                    lineStyle: {
                        color: '#408829',
                        type: 'dashed'
                    },
                    crossStyle: {
                        color: '#408829'
                    },
                    shadowStyle: {
                        color: 'rgba(200,200,200,0.3)'
                    }
                }
            },

            dataZoom: {
                dataBackgroundColor: '#eee',
                fillerColor: 'rgba(64,136,41,0.2)',
                handleColor: '#408829'
            },
            grid: {
                borderWidth: 0
            },

            categoryAxis: {
                axisLine: {
                    lineStyle: {
                        color: '#408829'
                    }
                },
                splitLine: {
                    lineStyle: {
                        color: ['#eee']
                    }
                }
            },

            valueAxis: {
                axisLine: {
                    lineStyle: {
                        color: '#408829'
                    }
                },
                splitArea: {
                    show: true,
                    areaStyle: {
                        color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
                    }
                },
                splitLine: {
                    lineStyle: {
                        color: ['#eee']
                    }
                }
            },
            timeline: {
                lineStyle: {
                    color: '#408829'
                },
                controlStyle: {
                    normal: {color: '#408829'},
                    emphasis: {color: '#408829'}
                }
            },

            k: {
                itemStyle: {
                    normal: {
                        color: '#68a54a',
                        color0: '#a9cba2',
                        lineStyle: {
                            width: 1,
                            color: '#408829',
                            color0: '#86b379'
                        }
                    }
                }
            },
            map: {
                itemStyle: {
                    normal: {
                        areaStyle: {
                            color: '#ddd'
                        },
                        label: {
                            textStyle: {
                                color: '#c12e34'
                            }
                        }
                    },
                    emphasis: {
                        areaStyle: {
                            color: '#99d2dd'
                        },
                        label: {
                            textStyle: {
                                color: '#c12e34'
                            }
                        }
                    }
                }
            },
            force: {
                itemStyle: {
                    normal: {
                        linkStyle: {
                            strokeColor: '#408829'
                        }
                    }
                }
            },
            chord: {
                padding: 4,
                itemStyle: {
                    normal: {
                        lineStyle: {
                            width: 1,
                            color: 'rgba(128, 128, 128, 0.5)'
                        },
                        chordStyle: {
                            lineStyle: {
                                width: 1,
                                color: 'rgba(128, 128, 128, 0.5)'
                            }
                        }
                    },
                    emphasis: {
                        lineStyle: {
                            width: 1,
                            color: 'rgba(128, 128, 128, 0.5)'
                        },
                        chordStyle: {
                            lineStyle: {
                                width: 1,
                                color: 'rgba(128, 128, 128, 0.5)'
                            }
                        }
                    }
                }
            },
            gauge: {
                startAngle: 225,
                endAngle: -45,
                axisLine: {
                    show: true,
                    lineStyle: {
                        color: [[0.2, '#86b379'], [0.8, '#68a54a'], [1, '#408829']],
                        width: 8
                    }
                },
                axisTick: {
                    splitNumber: 10,
                    length: 12,
                    lineStyle: {
                        color: 'auto'
                    }
                },
                axisLabel: {
                    textStyle: {
                        color: 'auto'
                    }
                },
                splitLine: {
                    length: 18,
                    lineStyle: {
                        color: 'auto'
                    }
                },
                pointer: {
                    length: '90%',
                    color: 'auto'
                },
                title: {
                    textStyle: {
                        color: '#333'
                    }
                },
                detail: {
                    textStyle: {
                        color: 'auto'
                    }
                }
            },
            textStyle: {
                fontFamily: 'Arial, Verdana, sans-serif'
            }
        };

        var echartBarLine = echarts.init(document.getElementById('mainb'), theme);

        echartBarLine.setOption({
            title: {
                x: 'center',
                y: 'top',
                padding: [0, 0, 20, 0],
                text: 'Server #{{ $server->id }} usage details.',
                textStyle: {
                    fontSize: 15,
                    fontWeight: 'normal'
                }
            },
            tooltip: {
                trigger: 'axis'
            },
            toolbox: {
                show: true,
                feature: {
                    dataView: {
                        show: true,
                        readOnly: false,
                        title: "Text View",
                        lang: [
                            "Text View",
                            "Close",
                            "Refresh"
                        ]
                    },
                    restore: {
                        show: true,
                        title: 'Restore'
                    },
                    saveAsImage: {
                        show: true,
                        title: 'Save'
                    }
                }
            },
            calculable: true,
            legend: {
                data: ['CPU', 'RAM'],
                y: 'bottom'
            },
            xAxis: [{
                type: 'category',
                data: [
                    @for($i = 50; $i >= 1; $i-=5)
                            "{{ Carbon\Carbon::now()->subMinutes($i)->diffForHumans() }}.",
                    @endfor
                ]
            }],
            yAxis: [{
                type: 'value',
                name: 'Amount',
                axisLabel: {
                    formatter: '{value} %'
                }
            }, {
                show: false,
                type: 'value',
                name: 'Amount',
                axisLabel: {
                    formatter: '{value} %'
                }
            }],
            series: [{
                name: 'CPU',
                type: 'line',
                smooth: true,
                itemStyle: {normal: {areaStyle: {type: 'default'}}},
                data:  {{  json_encode($server->used_cpu) }} ,
            }, {
                name: 'RAM',
                type: 'line',
                smooth: true,
                itemStyle: {normal: {areaStyle: {type: 'default'}}},
                data: {{ json_encode($server->used_ram) }},
            }]
        });
    </script>
    <!-- /ECharts -->

@endsection
