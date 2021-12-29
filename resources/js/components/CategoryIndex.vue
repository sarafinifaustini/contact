<template>
    <div>
        <div class="d-flex justify-content-between align-content-center mb-2">
            <div class="d-flex">
                <div>
                    <div class="d-flex align-items-center ml-4">
                        <label for="paginate" class="text-nowrap mr-2 mb-0"
                            >Per Page</label
                        >
                        <select
                            v-model="paginate"
                            class="form-control form-control-sm"
                        >
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="d-flex align-items-center ml-4">
                        <label for="paginate" class="text-nowrap mr-2 mb-0"
                            >FilterBy Class</label
                        >
                        <select
                            v-model="selectedClass"
                            class="form-control form-control-sm"
                        >
                            <option value="">All Class</option>
                            <option
                                v-for="item in classes"
                                :key="item.id"
                                :value="item.id"
                            >
                                {{ item.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div v-if="selectedClass">
                    <div class="d-flex align-items-center ml-4">
                        <label for="paginate" class="text-nowrap mr-2 mb-0"
                            >Section</label
                        >
                        <select
                            v-model="selectedSection"
                            class="form-control form-control-sm"
                        >
                            <option value="">Select a Section</option>
                            <option
                                v-for="section in sections"
                                :key="section.id"
                                :value="section.id"
                            >
                                {{ section.name}}
                            </option>
                        </select>
                    </div>
                </div>

                <div>
                    <div class="dropdown ml-4">
                        <button
                            v-if="checked.length > 0"
                            class="btn btn-secondary dropdown-toggle"
                            data-toggle="dropdown"
                        >
                            With Checked ({{ checked.length }})
                        </button>
                        <div class="dropdown-menu">
                            <a
                                href="#"
                                onclick="confirm('Are you sure you wanna delete this Record?') || event.stopImmediatePropagation()"
                                class="dropdown-item"
                                type="button"
                                @click.prevent="deleteRecords"
                            >
                                Delete
                            </a>

                            <a :href="url" class="dropdown-item" type="button">
                                Export
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <input
                    v-model.lazy="search"
                    type="search"
                    class="form-control"
                    placeholder="Search by name,email,phone,or year Joined..."
                />
            </div>
        </div>

        <div class="col-md-10 mb-2" v-if="selectPage">
            <div v-if="selectAll || teachers.meta.total == checked.length">
                You are currently selecting all
                <strong>{{ checked.length }}</strong> items.
            </div>
            <div v-else>
                You have selected <strong>{{ checked.length }}</strong> items,
                Do you want to Select All
                <strong>{{ teachers.meta.total }}</strong
                >?
                <a @click.prevent="selectAllRecords" href="#" class="ml-2"
                    >Select All</a
                >
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th><input type="checkbox" v-model="selectPage" /></th>
                        <!-- <th>
                            <a href="#" @click.prevent="change_sort('name')"
                                >Teacher's Name</a
                            >
                            <span
                                v-if="
                                    sort_direction == 'desc' &&
                                        sort_field == 'name'
                                "
                                >&uarr;</span
                            >
                            <span
                                v-if="
                                    sort_direction == 'asc' &&
                                        sort_field == 'name'
                                "
                                >&darr;</span
                            >
                        </th> -->
                        <th>
                            <a href="#" @click.prevent="change_sort('email')"
                                >Email</a
                            >
                            <span
                                v-if="
                                    sort_direction == 'desc' &&
                                        sort_field == 'email'
                                "
                                >&uarr;</span
                            >
                            <span
                                v-if="
                                    sort_direction == 'asc' &&
                                        sort_field == 'email'
                                "
                                >&darr;</span
                            >
                        </th>
                        <!-- <th>
                            <a href="#" @click.prevent="change_sort('parentName')"
                                >Parent's Name </a
                            >
                            <span
                                v-if="
                                    sort_direction == 'desc' &&
                                        sort_field == 'parentName'
                                "
                                >&uarr;</span
                            >
                            <span
                                v-if="
                                    sort_direction == 'asc' &&
                                        sort_field == 'parentName'
                                "
                                >&darr;</span
                            >
                        </th> -->
                        <th>
                            <a
                                href="#"
                                @click.prevent="change_sort('subject')"
                                >Subject</a
                            >
                            <span
                                v-if="
                                    sort_direction == 'desc' &&
                                        sort_field == 'subject'
                                "
                                >&uarr;</span
                            >
                            <span
                                v-if="
                                    sort_direction == 'asc' &&
                                        sort_field == 'subject'
                                "
                                >&darr;</span
                            >
                        </th>

                        <th>
                            <a
                                href="#"
                                @click.prevent="change_sort('created_at')"
                                >Created At</a
                            >
                            <span
                                v-if="
                                    sort_direction == 'desc' &&
                                        sort_field == 'created_at'
                                "
                                >&uarr;</span
                            >
                            <span
                                v-if="
                                    sort_direction == 'asc' &&
                                        sort_field == 'created_at'
                                "
                                >&darr;</span
                            >
                        </th>

                        <th>Class</th>
                        <th>Section</th>
                        <th>Action</th>
                    </tr>

                    <tr
                        v-for="teacher in teachers.data"
                        :key="teacher.id"
                        :class="isChecked(teacher.id) ? 'table-primary' : ''"
                    >
                        <td>
                            <input
                                type="checkbox"
                                :value="teacher.id"
                                v-model="checked"
                            />
                        </td>
                        <!-- <td>{{ teacher.name }}</td> -->
                        <td>{{ teacher.email }}</td>
                        <!-- <td>{{ teacher.parentName }}</td> -->
                        <td>{{ teacher.subject }}</td>
                         <!-- <td>{{ teacher.yearJoined }}</td> -->
                         <td>{{teacher.created_at}}</td>
                          <!-- <td>{{ teacher.yob }}</td> -->
                        <td>{{ teacher.class}}</td>
                        <td>{{ teacher.section}}</td>
                        <td>
                            <button
                                onclick="confirm('Are you sure you wanna delete this Record?') || event.stopImmediatePropagation()"
                                class="btn btn-danger btn-sm"
                                @click="deleteSingleRecord(teacher.id)"
                            >
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row mt-4">
            <div class="col-sm-6 offset-5">
                <pagination
                    :data="teachers"
                    @pagination-change-page="getTeachers"
                ></pagination>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            teachers: {},
            paginate: 10,
            search: "",
            classes: {},
            selectedClass: "",
            selectedSection: "",
            sections: {},
            checked: [],
            selectPage: false,
            selectAll: false,
            sort_direction: "desc",
            sort_field: "created_at",
            url: "",
            getTeachersUrl: "",
            getTeachersUrlWithoutPaginate: ""
        };
    },

    watch: {
        paginate: function(value) {
            this.getTeachers();
        },
        search: function(value) {
            this.getTeachers();
        },
        selectedClass: function(value) {
            this.selectedSection = "";
            axios
                .get("/api/sections?class_id=" + this.selectedClass)
                .then(response => {
                    this.sections = response.data.data;
                });
            this.getTeachers();
        },
        selectedSection: function(value) {
            this.getTeachers();
        },
        selectPage: function(value) {
            this.checked = [];
            if (value) {
                this.teachers.data.forEach(teacher => {
                    this.checked.push(teacher.id);
                });
            } else {
                this.checked = [];
                this.selectAll = false;
            }
        },
        checked: function(value) {
            this.url = "/api/teachers/export/" + this.checked;
        }
    },

    methods: {
        selectAllRecords() {
            axios.get(this.getTeachersUrlWithoutPaginate).then(response => {
                // console.log(response.data);
                this.checked = [];
                response.data.data.forEach(teacher => {
                    this.checked.push(teacher.id);
                });
                this.selectAll = true;
            });
        },
        change_sort(field) {
            if (this.sort_field == field) {
                this.sort_direction =
                    this.sort_direction == "asc" ? "desc" : "asc";
            } else {
                this.sort_field = field;
            }
            this.getTeachers();
        },
        deleteSingleRecord(teacher_id) {
            axios.delete("/api/teachers/delete/" + teacher_id).then(response => {
                this.checked = this.checked.filter(id => id != teacher_id);
                this.$toast.success("Teacher Deleted Successfully");
                this.getTeachers();
            });
        },
        deleteRecords() {
            axios
                .delete("/api/teachers/massDestroy/" + this.checked)
                .then(response => {
                    if (response.status == 204) {
                        this.$toast.success(
                            "Selected Teachers were Deleted Successfully"
                        );
                        this.checked = [];
                        this.getTeachers();
                    }
                });
        },
        isChecked(teacher_id) {
            return this.checked.includes(teacher_id);
        },
        getTeachers(page = 1) {
            this.getTeachersUrlWithoutPaginate =
                "/api/teachers?" +
                "q=" +
                this.search +
                "&sort_direction=" +
                this.sort_direction +
                "&sort_field=" +
                this.sort_field +
                "&selectedClass=" +
                this.selectedClass +
                "&selectedSection=" +
                this.selectedSection;

            this.getTeachersUrl = this.getTeachersUrlWithoutPaginate.concat(
                "&paginate=" + this.paginate + "&page=" + page
            );
            axios.get(this.getTeachersUrl).then(response => {
                this.teachers = response.data;
            });
        }
    },

    mounted() {
        axios.get("/api/classes").then(response => {
            this.classes = response.data.data;
        });
        this.getTeachers();
    }
};
</script>
