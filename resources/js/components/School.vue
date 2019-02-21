<template>
    <div>
        <h5>Passers Per School</h5>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">SCHOOL</th>
                <th scope="col">PASSERS</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="school in schools" v-bind:key="school.school">
                <th>{{school.school}}</th>
                <th>{{school.passed}}</th>
            </tr>
            </tbody>
        </table>
        <!--Pagination-->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item" v-bind:class="[{disabled: !pagination.first_page}]"><a class="page-link" href="#" @click="getPassersPerSchool(pagination.first_page)">First Page</a></li>
                <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page}]"><a class="page-link" href="#" @click="getPassersPerSchool(pagination.prev_page)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link" href="#">Page {{pagination.current_page}} of {{pagination.total_pages}}</a></li>
                <li class="page-item" v-bind:class="[{disabled: !pagination.next_page}]"><a class="page-link" href="#" @click="getPassersPerSchool(pagination.next_page)">Next</a></li>
                <li class="page-item" v-bind:class="[{disabled: !pagination.last_page}]"><a class="page-link" href="#" @click="getPassersPerSchool(pagination.last_page)">Last Page</a></li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        name: "School",
        data() {
            return {
                schools: [],
                pagination: {

                }
            }
        },
        methods: {
            getPassersPerSchool(page = 'http://webappetiserpshs.test/api/passers/school') {
                fetch(page)
                    .then(res => res.json())
                    .then(res => {
                        this.schools = res.data;
                        this.setPaginate(res);
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            setPaginate(res) {
                let pagination = {
                    current_page: res.current_page,
                    first_page: res.first_page_url,
                    last_page: res.last_page_url,
                    next_page: res.next_page_url,
                    prev_page: res.prev_page_url,
                    total_pages: res.last_page,
                    per_page: res.per_page
                };

                this.pagination = pagination;
            },
        },
        created() {
            this.getPassersPerSchool();
        }
    }
</script>

<style scoped>
    table>tbody {
        font-size: 0.7em;
    }
</style>
