import { Ability, AbilityBuilder } from '@casl/ability'
import { SET_USER, PURGE_AUTH } from '../store/mutations.type'

export const ability = new Ability()

export const abilityPlugin = (store) => {
    ability.update(store.state.rules)

    return store.subscribe((mutation) => {
        switch (mutation.type) {

            case SET_USER:

                let rules = [];

                mutation.payload.abilities.forEach(ability => {

                    let name = ability.name.toLowerCase();
                    let subject = 'all';
                    let conditions = {};

                    if (ability.entity_type != null) {
                        subject = ability.entity_type.split('App\\').join("");
                    }

                    if (ability.entity_id != null) {
                        conditions = {
                            'id': ability.entity_id
                        }
                    }

                    rules.push({ actions: name, subject: subject, conditions: conditions });

                })

                ability.update(rules);

                break

            case PURGE_AUTH:

                ability.update([
                    { actions: 'read', subject: 'event' },
                    { actions: 'read', subject: 'organisations' }
                ])

                break

        }
    })
}