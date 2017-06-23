<template>
    <star-rating @rating-selected="setRating" :read-only="readOnlyVice" :increment="increment" :rating="rating"
                 :star-size="size" :show-rating="ratetextflag">
    </star-rating>
</template>

<script>
    export default{
        props: {
            // 初始化的评分数
            'rating': {
                default: 0,
                type: Number
            },
            // 是否可读
            'readonly': {
                default: false,
                type: Boolean
            },
            // 星星的大小
            'size': {
                default: 20,
                type: Number
            },
            'increment': {
                defaule: 0.01,
                type: Number
            },
            'id': {
                default: 0,
                type: Number
            }
        },
        data () {
            return {
                ratetextflag: false, // 是否显示分数的文字
                readOnlyVice: this.readonly,
            }
        },
        methods: {
            setRating(rating){
                this.$emit('getEvaId',this.id);
                this.$emit('returnvalue', rating);
                this.readOnlyVice = true;
            },
        },
    }
</script>

<style lang="scss" scoped>

</style>