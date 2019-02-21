<template>
    <div>
        <!--Search Bar-->
        <h5>Search Bar</h5>
        <div class="input-group mb-3">
            <input v-model="query" type="text" class="form-control" placeholder="Search..." aria-label="Recipient's username" aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2" @click="searchPassers()">Search</button>
            </div>
        </div>
        <!--Add Examinee-->
        <h5>Add Examinee</h5>
        <form class="mb-2" @submit.prevent="addPasser()">
            <div class="form-group">
                <input v-model="passer.name_of_examinee" type="text" class="form-control" placeholder="Examinee Name" required>
            </div>
            <div class="form-group">
                <input v-model="passer.campus_eligibility" type="text" class="form-control" placeholder="Campus Eligibility" required>
            </div>
            <div class="form-group">
                <input v-model="passer.school" type="text" class="form-control" placeholder="School" required>
            </div>
            <div class="form-group">
                <input v-model="passer.division" type="text" class="form-control" placeholder="Division" required>
            </div>
            <button class="btn btn-primary">Save</button>
        </form>
        <!--Passers Table-->
        <h5>Passers</h5>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th scope="col">NAME OF EXAMINEE</th>
                <th scope="col">CAMPUS ELEGIBILITY</th>
                <th scope="col">SCHOOL</th>
                <th scope="col">CAMPUS</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="passer in passers" v-bind:key="passer.id">
                <th scope="row">{{passer.id}}</th>
                <th>{{passer.name_of_examinee}}</th>
                <th>{{passer.campus_eligibility}}</th>
                <th>{{passer.school}}</th>
                <th>{{passer.division}}</th>
            </tr>
            </tbody>
        </table>
        <!--Pagination-->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item" v-bind:class="[{disabled: !pagination.first_page}]"><a class="page-link" href="#" @click="is_search ? searchPassers(pagination.first_page) : getPassers(pagination.first_page)">First Page</a></li>
                <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page}]"><a class="page-link" href="#" @click="is_search ? searchPassers(pagination.prev_page) : getPassers(pagination.prev_page)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link" href="#">Page {{pagination.current_page}} of {{pagination.total_pages}}</a></li>
                <li class="page-item" v-bind:class="[{disabled: !pagination.next_page}]"><a class="page-link" href="#" @click="is_search ? searchPassers(pagination.next_page) : getPassers(pagination.next_page)">Next</a></li>
                <li class="page-item" v-bind:class="[{disabled: !pagination.last_page}]"><a class="page-link" href="#" @click="is_search ? searchPassers(pagination.last_page) : getPassers(pagination.last_page)">Last Page</a></li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        name: "Passers",
        data() {
            return {
                passers: [],
                pagination: {},
                query: '',
                is_search: false,
                passer: {
                    name_of_examinee:'',
                    campus_eligibility:'',
                    school:'',
                    division:'',
                }
            }
        },
        created() {
            this.getPassers();
        },
        methods: {
            getPassers(page = 'api/passers') {
                this.is_search = false;
                fetch(page)
                    .then(res => res.json())
                    .then(res => {
                        this.passers = res.data;
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
            searchPassers(page = 'api/passers/search?page=1') {
                this.is_search = true;
                fetch(page + '&q=' + this.query)
                    .then(res => res.json())
                    .then(res => {
                        this.passers = res.data;
                        this.setPaginate(res)
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            addPasser() {
                fetch('api/passers', {
                    method: 'POST',
                    body: JSON.stringify(this.passer),
                    headers: {
                        'content-type':'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        this.passer = {
                            name_of_examinee:'',
                            campus_eligibility:'',
                            school:'',
                            division:'',
                        };
                        alert('Passer Added');
                        this.getPassers();
                    })
                    .catch(err => {
                        console.log(err);
                    });
            }
        }
    }
</script>

<style scoped>
    table>tbody {
        font-size: 0.7em;
    }
</style>
