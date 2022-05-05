<template>
    <cytoscape ref="cyRef" :config="config" :sync="true" :preConfig="preConfig" :afterCreated="afterCreated"/>
</template>

<script>
import COSEBilkent from 'cytoscape-cose-bilkent';

export default {
    props: {
        questions: { type: Array, required: true }
    },
    created(){
        const elements = [];

        this.questions.forEach(question => {
            elements.push({ data: { id: question.id, label: question.question } });
            question.options.forEach(option => {
                const item = { data: {
                        id: `rel-${option.id}`,
                        source: option.question_id,
                        target: option.next_question_id,
                        label: option.name,
                    }};
                if (option.next_question_id != null)
                    elements.push(item);
            });
        });
        this.elements = elements;
        //console.log(this.elements);
    },
    data(){
        return {
            elements: [],
            config: {
                style: [
                    {
                        selector: 'node[label]',
                        style: {
                            label: 'data(label)',
                        },
                    },
                    {
                        selector: 'edge[label]',
                        style: {
                            label: 'data(label)',
                            'curve-style': 'bezier',
                        },
                    },
                ],
            },
        }
    },

    methods: {
        preConfig(Cytoscape) {
            Cytoscape.use(COSEBilkent);
        },
        afterCreated(cy) {
            // add elements and run layout algorithm
            cy.add(this.elements)
                .layout({ name: 'cose-bilkent',
                    idealEdgeLength: this.questions.length < 9 ? 100 : 200
                })
                .run();
        },
    },
}
</script>

<style scoped>

</style>
