<template>
    <Nav>
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div id="container"></div>
                    </div>
                </div>
            </div>
        </div>
    </Nav>
    <!--    <Footer/>-->
</template>
<script>
import HighchartsVue from 'highcharts-vue';
import Highcharts from 'highcharts';

export default {
    components: {highcharts: HighchartsVue.component},
    mounted() {
        this.fetchPosts()
        // setTimeout((e) => {
        //     this.chart();
        // }, 1000)
    },
    methods: {
        fetchSentiments(comments) {
            this.axios
                .post(this.$sentimentsBaseUrl + "/analyze_posts", {posts: comments}, {
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then((response) => {
                    // console.log("Response:", response.data);
                    this.posts = response.data.data

                    this.chart(this.posts);
                    // this.posts.map((post) => {
                    //     let sum = post.total.positive + post.total.negative + post.total.neutral
                    //     this.chart()
                    // })
                })
                .catch((error) => {
                    console.error("Error:", error);
                    // Handle error response
                });
        },
        fetchPercentage(value,sum){
            if (value == 0){
                return 0
            }
            return parseFloat((value / sum * 100).toFixed(2));
        },
        fetchPosts() {
            this.axios
                .get(this.$baseUrl + "/api/post/list", {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem("token")}`,
                            "Content-Type": "application/json",
                        }
                    },
                )
                .then((response) => {
                    console.log(response)
                    this.posts = response.data.data
                    this.fetchSentiments(this.posts)
                    this.Loader = false
                })
                .catch((error) => {
                    console.log(error.response.data.status);
                    this.Loader = false
                    if (error.response.data.message === "Unauthenticated.") {
                        localStorage.clear();
                        setTimeout(() => {
                            this.$router.push({name: "Login"});
                        }, 1000);
                    }
                });
        },
        chart(data) {
            console.log(data,"inchart")
            const categories = data.posts.map((_, index) => index + 1);
            const positiveData = data.posts.map((post) => {
                let sum = post.total.positive + post.total.negative + post.total.neutral
                return this.fetchPercentage(post.total.positive,sum)
            });
            const negativeData = data.posts.map((post) => {
                let sum = post.total.positive + post.total.negative + post.total.neutral
                return this.fetchPercentage(post.total.negative,sum)
            });
            const neutralData = data.posts.map((post) => {
                let sum = post.total.positive + post.total.negative + post.total.neutral
                return this.fetchPercentage(post.total.neutral,sum)
            });

            let totalSum = data.overall_total.positive + data.overall_total.negative + data.overall_total.neutral
            const totalPositive = this.fetchPercentage(data.overall_total.positive,totalSum)
            const totalNegative = this.fetchPercentage(data.overall_total.negative,totalSum)
            const totalNeutral = this.fetchPercentage(data.overall_total.neutral,totalSum)
            const totalPositiveNum = data.overall_total.positive
            const totalNegativeNum = data.overall_total.negative
            const totalNeutralNum = data.overall_total.neutral
            // const averageData = positiveData.map((val, index) => {
            //     return (val + (neutralData[index] || 0) + (negativeData[index] || 0)) / 3;
            // });

            // console.log(averageData)
            Highcharts.chart('container', {
                title: {
                    text: 'Overall Posts Sentiments Result',
                    align: 'center'
                },
                xAxis: {
                    categories: categories,
                    title: {
                        text: 'No. of Posts'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Percentage %'
                    }
                },
                // tooltip: {
                //     valueSuffix: ' %'
                // },
                plotOptions: {
                    series: {
                        borderRadius: '25%'
                    }
                },
                series: [{
                    type: 'column',
                    name: 'Positive',
                    data: positiveData,
                    color:"#00e272"
                }, {
                    type: 'column',
                    name: 'Negative',
                    data: negativeData,
                    color: "#fe6a35"
                }, {
                    type: 'column',
                    name: 'Neutral',
                    data: neutralData,
                    color: "#a6a6a6"
                }, {
                    type: 'pie',
                    name: 'Total',
                    tooltip: {
                        pointFormat: '{point.name}: <b>{point.y}%</b>'  // Show the percentage value in the tooltip
                    },
                    data: [{
                        name: 'Total Neutral',
                        y: totalNeutral,
                        color: "#a6a6a6",
                        dataLabels: {
                            enabled: true,
                            distance: -50,
                            format: 'Total',
                            style: {
                                fontSize: '15px'
                            }
                        }
                    },{
                        name: 'Total Positive',
                        y: totalPositive,
                        color: "#00e272" // 2021 color
                    }, {
                        name: 'Total Negative',
                        y: totalNegative,
                        color: "#fe6a35"
                    }],
                    center: [75, 30],
                    size: 100,
                    innerSize: '70%',
                    showInLegend: false,
                    dataLabels: {
                        enabled: false
                    }
                }, {
                    type: 'pie',
                    name: 'Total',
                    data: [{
                        name: 'Total Neutral',
                        y: totalNeutralNum,
                        color: "#a6a6a6",
                        dataLabels: {
                            enabled: true,
                            distance: -50,
                            format: '{point.total} Comments',
                            style: {
                                fontSize: '10px'
                            }
                        }
                    },{
                        name: 'Total Positive',
                        y: totalPositiveNum,
                        color: "#00e272" // 2021 color
                    }, {
                        name: 'Total Negative',
                        y: totalNegativeNum,
                        color: "#fe6a35"
                    }],
                    center: [200, 30],
                    size: 100,
                    innerSize: '70%',
                    showInLegend: false,
                    dataLabels: {
                        enabled: false
                    }
                }]
            });
        },
    }
}
</script>
