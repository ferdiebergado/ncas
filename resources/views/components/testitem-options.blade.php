<div x-data="data()">
    <div class="field is-grouped">
        <p class="control is-expanded">
            <input id="option" class="input" type="text" placeholder="Option" x-model.lazy="option">
        </p>
        <p class="control">
            <a id="btn-add" class="button is-info" x-on:click="add()">
                Add
            </a>
        </p>
    </div>

    <template x-if="options">
        <div class="field is-grouped">
            <template x-for="(opt, i) in options" :key="i">
                <div>
                    <p class="control is-expanded">
                        <input id="opts[i]" class="input" type="text" placeholder="Option" name="opts[i]"
                            :x-ref="'opts' + i" x-model="options[i]" x-bind:readonly="!edit_mode && index == i">
                    </p>
                    <p class="control">
                        <a class="button is-info" x-on:click="edit(opt)" x-on:click.away="reset()">
                            <span x-text="(edit_mode && index == i) ? 'Save' : 'Edit'"></span>
                        </a>
                        <a class="button is-info" x-on:click="del(opt)">
                            Delete
                        </a>
                    </p>
                </div>
            </template>
        </div>
    </template>
</div>

@push('scripts')

<script>
    function data() {
        return {
            options: [],
            option: '',
            index: undefined,
            edit_mode: false,
            setIndex(opt) {
                this.index = this.options.indexOf(opt);
            },
            reset() {
                this.option = '';
                this.edit_mode = false;
            },
            add() {
                if (this.option != '') {
                    this.options.push(this.option);
                    this.reset();
                }
            },
            edit(opt) {
                this.edit_mode = !this.edit_mode;
                this.setIndex(opt);

                if (this.edit_mode) {
                    (this.$refs.opts + this.index)[0].focus();
                    return;
                }

                this.options.splice(this.index, 1, this.options[this.index]);
                this.reset();
            },
            delete(opt) {
                this.setIndex(opt);
                this.options.splice(this.index, 1);
            },
        }
    }
</script>

@endpush
