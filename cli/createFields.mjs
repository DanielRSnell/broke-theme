import axios from 'axios';
import inquirer from 'inquirer';
import fs from 'fs-extra';
import yaml from 'js-yaml';
import path from 'path';
import { fileURLToPath } from 'url';
import chalk from 'chalk';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const configPath = path.join(__dirname, 'broke.json');
const blocksDirPath = path.join(__dirname, '..', 'theme', 'blocks');

async function fetchConfig() {
    const config = await fs.readJson(configPath);
    return config.local;
}

async function fetchACFFieldTypes(baseUrl) {
    const response = await axios.get(`${baseUrl}/wp-json/broke/v1/field_types`);
    return response.data;
}

async function selectBlock() {
    const blocks = (await fs.readdir(blocksDirPath)).filter(file => fs.statSync(path.join(blocksDirPath, file)).isDirectory());
    const { selectedBlock } = await inquirer.prompt([{
        type: 'list',
        name: 'selectedBlock',
        message: 'Select a block:',
        choices: blocks
    }]);
    return selectedBlock;
}

async function selectFieldsByCategory(fieldTypes) {
    let categories = {};
    Object.keys(fieldTypes).forEach(key => {
        const category = fieldTypes[key].category;
        if (!categories[category]) {
            categories[category] = [];
        }
        categories[category].push(key);
    });

    let fields = [];
    let addMoreCategory = true;

    while (addMoreCategory) {
        let categoryChoices = Object.keys(categories);
        categoryChoices.push(new inquirer.Separator(), 'Go back and choose another category', new inquirer.Separator());

        const { selectedCategory } = await inquirer.prompt([{
            type: 'list',
            name: 'selectedCategory',
            message: 'Select a field type category:',
            choices: categoryChoices
        }]);

        if (selectedCategory === 'Go back and choose another category') continue;

        let addMoreFields = true;
        while (addMoreFields) {
            let fieldChoices = [...categories[selectedCategory], 'Go back and choose another field'];
            
            const { selectedField } = await inquirer.prompt([{
                type: 'list',
                name: 'selectedField',
                message: 'Select a field from the category:',
                choices: fieldChoices
            }]);

            if (selectedField === 'Go back and choose another field') continue;

            const { label } = await inquirer.prompt([{
                type: 'input',
                name: 'label',
                message: `Label for ${selectedField}:`
            }]);
            const name = label.toLowerCase().replace(/ /g, '_');

            fields.push({
                key: `field_${name}`,
                label,
                name,
                type: selectedField
            });

            const { addAnotherField } = await inquirer.prompt([{
                type: 'confirm',
                name: 'addAnotherField',
                message: 'Would you like to add additional fields from this category?',
                default: false
            }]);
            addMoreFields = addAnotherField;
        }

        const { addAnotherCategory } = await inquirer.prompt([{
            type: 'confirm',
            name: 'addAnotherCategory',
            message: 'Would you like to add fields from another category?',
            default: false
        }]);
        addMoreCategory = addAnotherCategory;
    }

    return fields;
}

async function createFieldGroup(blockName, fieldTypes) {
    const fields = await selectFieldsByCategory(fieldTypes);

    let fieldGroup = {
        field_groups: [{
            key: `group_${blockName}`,
            title: `${blockName} Fields`,
            fields: fields.map(field => ({
                key: field.key,
                label: `'${field.label}'`,
                name: `'${field.name}'`,
                type: `'${field.type}'`
            })),
            location: [[{ param: 'block', operator: '==', value: `acf/${blockName}` }]]
        }]
    };

    const yamlStr = yaml.dump(fieldGroup, { noRefs: true });
    await fs.outputFile(path.join(blocksDirPath, blockName, 'fields.md'), `---\n${yamlStr}---`.split("''").join('').split("'").join('"'));
    console.log(chalk.blue(`fields.md has been generated for ${blockName} at ${path.join(blocksDirPath, blockName, 'fields.md')}`));
}

async function main() {
    const baseUrl = await fetchConfig();
    const fieldTypes = await fetchACFFieldTypes(baseUrl);
    const blockName = await selectBlock();
    await createFieldGroup(blockName, fieldTypes);
}

main().catch(err => console.error(chalk.red(err)));
