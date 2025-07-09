{
	tooltip: {
		trigger: 'item',
		formatter: '{b}'
	},
	geo:[
		{
			regions:{
				itemStyle: {
					areaColor:'#083b8a',
				}
			}
		}
	],
	series: [
		{
			name: '中国',
			type: 'map',
			mapType: 'china',
			// selectedMode: false,
			label: {
				show: false,
			},
			itemStyle: {
				normal: {
					borderWidth: 2,//边际线大小
					borderColor:'#ffffff',//边界线颜色
					areaColor:'#dddddd',//默认区域颜色
					color:'#dddddd',
				},
				emphasis: {
					show: false,
					selectedMode: false,
					// areaColor: '#083b8a',//鼠标滑过区域颜色
					// shadowBlur: '#ff0000',
					color:"#dddddd",
					label: {
						show: false,
						textStyle: {
							color: '#fff'
						}
					},


				}
			},
			data: [
				{name: '新疆', selected: true,
					itemStyle: {
						emphasis: {
							color:'#083b8a',
						}
					}
				},
                {name: '西藏', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#083b8a',
                        }
                    }
                },
                {name: '甘肃', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#083b8a',
                        }
                    }
                },
                {name: '内蒙古', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#083b8a',
                        }
                    }
                },
                {name: '宁夏', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#083b8a',
                        }
                    }
                },
                {name: '陕西', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#083b8a',
                        }
                    }
                },
                {name: '山西', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#083b8a',
                        }
                    }
                },
                {name: '山东', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#083b8a',
                        }
                    }
                },
                {name: '河北', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#083b8a',
                        }
                    }
                },
                {name: '北京', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#083b8a',
                        }
                    }
                },
                {name: '天津', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#083b8a',
                        }
                    }
                },
                {name: '辽宁', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#083b8a',
                        }
                    }
                },
                {name: '吉林', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#083b8a',
                        }
                    }
                },
                {name: '黑龙江', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#083b8a',
                        }
                    }
                },
                {name: '青海', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#083b8a',
                        }
                    }
                },

			],
			data: [
                {name: '云南', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#ffca00',
                        }
                    }
                },
                {name: '四川', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#ffca00',
                        }
                    }
                },
                {name: '重庆', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#ffca00',
                        }
                    }
                },
                {name: '贵州', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#ffca00',
                        }
                    }
                },
                {name: '湖南', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#ffca00',
                        }
                    }
                },
                {name: '湖北', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#ffca00',
                        }
                    }
                },
                {name: '江西', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#ffca00',
                        }
                    }
                },
                {name: '安徽', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#ffca00',
                        }
                    }
                },
                {name: '河南', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#ffca00',
                        }
                    }
                },
			],
			data: [
                {name: '安徽', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#8ec965',
                        }
                    }
                },
                {name: '江苏', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#8ec965',
                        }
                    }
                },
                {name: '浙江', selected: true,
                    itemStyle: {
                        emphasis: {
                            color:'#8ec965',
                        }
                    }
                },
			],
			data: [
				{name: '广东', selected: true,
					itemStyle: {
						emphasis: {
							color:'#ea5f3b',
						}
					}
				},
				{name: '福建', selected: true,
					itemStyle: {
						emphasis: {
							color:'#ea5f3b',
						}
					}
				},
				{name: '香港', selected: true,
					itemStyle: {
						emphasis: {
							color:'#ea5f3b',
						}
					}
				},
				{name: '澳门', selected: true,
					itemStyle: {
						emphasis: {
							color:'#ea5f3b',
						}
					}
				},
				{name: '广西', selected: true,
					itemStyle: {
						emphasis: {
							color:'#ea5f3b',
						}
					}

				},
				{name: '海南', selected: true,
					itemStyle: {
						emphasis: {
							color:'#ea5f3b',
						}
					}
				},
				{name: '台湾', selected: true,
					itemStyle: {
						emphasis: {
							color:'#ea5f3b',
						}
					}
				},
			],
			
			
		}
	]
};