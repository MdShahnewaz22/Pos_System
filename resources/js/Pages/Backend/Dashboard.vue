<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import BackendLayout from '@/Layouts/BackendLayout.vue';
import BarChart from '@/Components/Chart/BarChart.vue';
import PieChart from '@/Components/Chart/PieChart.vue';
import DoughnutChart from '@/Components/Chart/DoughnutChart.vue';
import LineChart from '@/Components/Chart/LineChart.vue';
import PolarAreaChart from '@/Components/Chart/PolarAreaChart.vue';
import RadarChart from '@/Components/Chart/RadarChart.vue';


const props = defineProps(['dashboardData']);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

//bar chat last 10 year
import { ref } from 'vue'

const currentYear = new Date().getFullYear()

const barChartData = ref({
  labels: Array.from({ length: 10 }, (_, i) => `${currentYear - 9 + i}`),
  datasets: [
    {
      label: 'Product Sales',
      backgroundColor: '#3B82F6',
      data: [120, 150, 180, 220, 240, 300, 330, 350, 370, 400],
    }
  ]
})

</script>

<template>
    <BackendLayout>

        <section class="grid gap-4 mt-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="flex flex-col bg-white rounded-lg shadow md:col-span-2 md:row-span-2">
                <div class="px-6 py-5 font-semibold border-b border-gray-100">Total Product Sales Per Month
                </div>
                <div class="flex-grow p-4">
                    <div
                        class="flex items-center justify-center h-full px-4 py-16 text-3xl font-semibold text-gray-400 bg-gray-100 border-2 border-gray-200 border-dashed rounded-md">
                        <BarChart />
                    </div>
                </div>
            </div>


            <div class="flex flex-col bg-white rounded-lg shadow md:col-span-2 md:row-span-2">
                <div class="px-6 py-5 font-semibold border-b border-gray-100">
                    Total Product Sales (Last 10 Years)
                </div>
                <div class="flex-grow p-4">
                    <div
                        class="flex items-center justify-center h-full px-4 py-8 text-gray-700 bg-gray-100 border-2 border-gray-200 border-dashed rounded-md">
                        <BarChart :data="barChartData" />
                    </div>
                </div>
            </div>



        </section>
    </BackendLayout>
</template>
