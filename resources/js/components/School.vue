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
    </div>
</template>

<script>
    export default {
        name: "School",
        data() {
            return {
                schools: []
            }
        },
        methods: {
            getPassersPerSchool() {
                fetch('http://webappetiserpshs.test/api/passers/school')
                    .then(res => res.json())
                    .then(data => {
                        this.schools = data;
                    })
                    .catch(err => {
                        console.log(err);
                    });
            }
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
